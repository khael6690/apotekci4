<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\ObatModel;
use App\Models\ProfileModel;
use App\Models\BuyModel;
use App\Models\BuyDetailModel;

define('_TITLE', 'Transaksi Beli');

class Transbeli extends BaseController
{
    private $_m_obat, $_m_buy, $_buy_detail, $_m_profile, $_cart;
    public function __construct()
    {
        $this->_m_buy = new BuyModel();
        $this->_buy_detail = new BuyDetailModel();
        $this->_cart = \Config\Services::cart();
        $this->_m_obat = new ObatModel();
        $this->_m_profile = new ProfileModel();
    }

    public function index()
    {
        $this->_cart->destroy();
        $produk = $this->_m_obat->getObat();
        $data = [
            'title' => _TITLE,
            'produk' => $produk
        ];
        return view('transbeli/index', $data);
    }

    public function add_cart($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id === null) {
                $this->_cart->insert(array(
                    'id'      => $this->request->getVar('obat_id'),
                    'qty'     => 1,
                    'price'   => $this->request->getVar('harga'),
                    'name'    => $this->request->getVar('nama'),
                    'options' => array(
                        'discount' => $this->request->getVar('discount')
                    )
                ));

                return $this->show_cart();
            } elseif ($id !== null) {
                $produk = $this->_m_obat->getObat($id);
                if ($produk !== null) {
                    $this->_cart->insert(array(
                        'id'      => $produk['id_obat'],
                        'qty'     => 1,
                        'price'   => $produk['harga'],
                        'name'    => $produk['nama_obat'],
                        'options' => array(
                            'discount' => $produk['discount']
                        )
                    ));

                    return $this->show_cart($id);
                } else {
                    return $this->show_cart($id);
                }
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function show_cart($id = null)
    {
        $data = $this->_cart->contents();
        if ($data != null) {
            $item = [
                'data' => $data
            ];

            $isi = view('transbeli/items', $item);

            $json = [
                'status' => true,
                'data' =>  $isi,
                'msg' => 'Success'
            ];
        } else {
            $json = [
                'status' => false,
                'data' =>  $id,
                'msg' => 'Data tidak ditemukan!'
            ];
        }

        return $this->response->setJSON($json);
    }

    public function delete_cart($rowid)
    {
        if ($this->request->isAJAX()) {
            $this->_cart->remove($rowid);

            return $this->show_cart();
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update_cart($rowid)
    {
        if ($this->request->isAJAX()) {
            $this->_cart->update(array(
                'rowid'   => $rowid,
                'qty'     => $this->request->getVar('qty')
            ));
            return $this->show_cart();
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function total()
    {
        $total = 0;
        foreach ($this->_cart->contents() as $items) {
            $discount = ($items['options']['discount'] / 100)  * $items['subtotal'];
            $total += $items['subtotal'] - $discount;
        }
        return $total;
    }

    public function getTotal()
    {
        $total = number_to_currency($this->total(), 'IDR', 'id_ID', 2);
        return $this->response->setJSON($total);
    }

    public function getDiskon()
    {
        if ($this->request->isAJAX() && $this->_cart->contents()) {
            $total = $this->total();
            $diskon = ($this->request->getPost('diskon') / 100) * $total;
            $totbayar = $total - $diskon;
            $totbayar === 0 ? $totbayar = 0 : $totbayar;
            $json = [
                'status' => 200,
                'totbayar' => $totbayar
            ];
            return $this->response->setJSON($json);
        } elseif ($this->request->isAJAX() && !$this->_cart->contents()) {
            $json = [
                'totbayar' => null,
                'status' => 404
            ];
            return $this->response->setJSON($json);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function getKembalian()
    {
        if ($this->request->isAJAX()) {
            $nominal = $this->request->getPost('nominal');
            $totbayar = $this->request->getPost('totbayar');
            if ($totbayar !== null && $nominal !== null) {
                $json = [
                    'status' => 404,
                    'kembalian' => null
                ];
            }
            $kembalian = ($nominal - $totbayar);
            $json = [
                'status' => 200,
                'kembalian' => $kembalian
            ];

            return $this->response->setJSON($json);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function pay()
    {
        if ($this->request->isAJAX()) {
            if (!$this->_cart->contents()) {
                $response = [
                    'status' => 404,
                    'title' => 'Transaksi gagal',
                    'msg' => 'Tidak ada transaksi!'
                ];
                return $this->response->setJSON($response);
            } else {
                //ada transaksi
                $totbayar = $this->request->getVar('totbayar');
                $nominal = $this->request->getVar('nominal');

                if ($nominal < $totbayar) {
                    //nominal tidak cukup
                    $response = [
                        'status' => 405,
                        'title' => 'Transaksi gagal',
                        'msg' => 'Nominal tidak mencukupi!'
                    ];
                    return $this->response->setJSON($response);
                } else {
                    //nominal cukup
                    $buyid = $this->request->getVar('buyid');
                    $supplier = $this->request->getVar('supplier');
                    $discountval = $this->request->getVar('discount');
                    // simpan ke buy table
                    $this->_m_buy->save([
                        'buyid' => $buyid,
                        'userid' => user_id(),
                        'supplier' => $supplier,
                        'discount' => $discountval
                    ]);

                    foreach ($this->_cart->contents() as $items) {
                        $discount = ($items['options']['discount'] / 100)  * $items['subtotal'];
                        $this->_buy_detail->save([
                            'buyid' => $buyid,
                            'id_obat' => $items['id'],
                            'amount' => $items['qty'],
                            'price' => $items['price'],
                            'discount' => $discount,
                            'total_price' => $items['subtotal'] - $discount
                        ]);
                    }
                    // JSON sukses
                    $response = [
                        'status' => 200,
                        'title' => 'Transaksi berhasil',
                        'msg' => 'Pembayaran selesai!',
                        'value' => $supplier
                    ];
                    return $this->response->setJSON($response);
                }
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function reset()
    {
        if ($this->request->isAJAX()) {
            $this->_cart->destroy();
            $json = [
                'status' => 200
            ];
            return $this->response->setJSON($json);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }
}
