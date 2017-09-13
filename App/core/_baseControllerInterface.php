<?php
/**
 * Created by PhpStorm.
 * User: macbook
 * Date: 8/8/17
 * Time: 9:51 AM
 */

interface _baseControllerInterface{

    public function viewall();
    public function add();
    public function edit($id);
    public function delete($id);
    public function details($id);



}