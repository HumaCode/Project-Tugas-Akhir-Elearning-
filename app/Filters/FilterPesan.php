<?php

namespace App\Filters;

use App\Models\ModelChat;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class FilterPesan implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $modelMessages = new ModelChat();
        $message = $modelMessages->find($request->uri->getSegment(3));

        if (!$message) {
            return redirect()->to(base_url('chat/index'));
        }

        // jika bukan recipient dn sender / penerima dan pengirim maka
        if (session()->id_user != $message['id_penerima'] && session()->id_user != $message['id_pengirim']) {
            return redirect()->to(base_url('chat/index'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
