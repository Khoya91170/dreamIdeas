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
    public $description;

    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id_Community'])) ? $data['id_Community'] : null;
        $this->name = (!empty($data['name_Community'])) ? $data['name_Community'] : null;
        $this->description = (!empty($data['description_Community'])) ? $data['description_Community'] : null;
    }
}
?>