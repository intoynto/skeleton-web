<?php
declare (strict_types=1);

namespace App\Models;

use Intoy\HebatDatabase\Model;

class UserModel extends Model
{
    /**
    * @var string data name
    */
    protected $name="Data User";

    /**
    * @var string table name in database
    */
    protected $table="ua";

    /**
    * @var string view name in database
    */
    protected $view="";


    protected $fields=[];

    protected $view_fields=[];

    protected $fields_search_string=[];

    protected $fields_where_string=[];

    protected $fields_search_int=[];

    const F_ID="id_user";
    const F_USERNAME="uname";
    const F_PASSWORD="upass";
    const F_LEVEL="tipe";

    const D_TIPE_ADMIN=1;
    const D_TIPE_USER=2;
}