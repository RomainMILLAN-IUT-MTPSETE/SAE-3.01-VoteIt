<?php
namespace App\VoteIt\Model\DataObject;

abstract class AbstractDataObject{
    public abstract function formatTableau(): array;
}
