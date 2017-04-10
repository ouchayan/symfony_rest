<?php
namespace AppBundle\Handler;


interface HandlerInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    public function all();
    
}