<?php
namespace common\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
/**
* This component implementat some hash function, or compat if avaible
* hkdf, pkdf2 and scrypt
*/
class Crypto extends Component
{
  /**
  * HKDF implementation
  * old order (from vinpel/php-crypto ):
  * static function hkdf($key, $digest = 'sha512', $salt = NULL, $length = NULL, $info = '')
  * we now use the new standard order
  *
  * @param string Name of selected hashing algorithm (i.e. "sha256", "sha512", "haval160,4", etc..)
  * @param string Input keying material (raw binary). Cannot be empty.
  * @param integer Desired output length in bytes. Cannot be greater than 255 times the chosen hash function size
  */
  public function hkdf($algo,$ikm,$length=0,$info = '',$salt=''){
    //if PHP_VERSION > 7.1.2 use internal function, else
    //use of userland function  narf/hash_hkdf_compat
    if (!function_exists('hash_hkdf')){
      $compat=yii::getAlias('@vendor/narf/hash_hkdf_compat/src/hash_hkdf.php');
      if (is_file($compat)){
        require $compat;
      }else{
        throw new InvalidConfigException('compat file for hash_hkdf not found');
      }
    }
    if (!function_exists('hash_hkdf')){
      throw new InvalidConfigException('function hash_hkdf not found');
    }
    return hash_hkdf ( $algo ,$ikm , $length,$info ,$salt );
  }
}
