<?php
/**
 * Created by PhpStorm.
 * User: Sami
 * Date: 09/06/2015
 * Time: 10:51
 */

namespace Application\Model;

class Group
{
    public $id;
    public $name;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
    }
}
?>