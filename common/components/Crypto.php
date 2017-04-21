<?php
namespace common\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;

use common\components\Zend\Scrypt;
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
        require_once($compat);
      }else{
        throw new InvalidConfigException('compat file for hash_hkdf not found');
      }
    }
    if (!function_exists('hash_hkdf')){
      throw new InvalidConfigException('function hash_hkdf not found');
    }
    return hash_hkdf ( $algo ,$ikm , $length,$info ,$salt );
  }
  /**
  * Generate a PBKDF2 key derivation of a supplied password
  * old order : ($hash, $password, $salt, $iterations, $length)
  */
  public function pbkdf2( $algo ,  $password ,  $salt ,  $iterations ,  $length ){
    if (!function_exists('hash_pbkdf2')){
      throw new InvalidConfigException('no hash_pbkdf2 function implented since php 5.5');
    }

  return hash_pbkdf2 ( $algo ,  $password ,  $salt ,  $iterations ,  $length);
}
/**
* Scrypt function, using libsodium by default
* scrypt($pass, $salt,$N,$r,$p,$size){
* @param old string salt a random string
* @param old integer N = opslimit : the CPU cost; (pow of 2)
* @param old integer r = memlimit : the memory cost;
* @param old integer p : the parallelization cos
*/
public function scrypt($password,$salt,  $opslimit = null,  $memlimit = null,  $out_len=null,$keysize=64){
  //did we have the libsodium extension ??

  // scrypt can't set salt for now ... so i comment the code
  /*  if (function_exists('\Sodium\library_version_major')){
  if (is_null($opslimit)){
  $opslimit = \Sodium\CRYPTO_PWHASH_SCRYPTSALSA208SHA256_OPSLIMIT_INTERACTIVE;
}
if (is_null($memlimit)){
$memlimit = \Sodium\CRYPTO_PWHASH_SCRYPTSALSA208SHA256_MEMLIMIT_INTERACTIVE;
}
if (is_null($out_len)){
$out_len=\Sodium\CRYPTO_SIGN_SEEDBYTES;
}

//Please note that r is specified in kilobytes, and not in bytes as in the Sodium API.

var_dump(\Sodium\randombytes_buf(\Sodium\CRYPTO_PWHASH_SCRYPTSALSA208SHA256_SALTBYTES));
exit;


// create a random salt
$salt = \Sodium\randombytes_buf(\Sodium\CRYPTO_PWHASH_SCRYPTSALSA208SHA256_SALTBYTES);

//zend_error(E_WARNING) provoque a yii error
$old_error_level=error_reporting();
error_reporting(E_ALL ^ E_WARNING);

// generate a stream of $out_len pseudo random bytes
// using the password and the salt; this can be used to generate secret keys
$out_len = 200;

//$salt=settype($salt,\Sodium\CRYPTO_PWHASH_SCRYPTSALSA208SHA256_SALTBYTES);
//($password,$salt,  $opslimit = null,  $memlimit = null,  $out_len=null,$keysize=64){


$salt=hex2bin("aff9f66665e0617e7d2c06952a050590ed5313167fdbc8d49f20c650201848a8");
var_dump(($salt));

$key = \Sodium\crypto_pwhash_scryptsalsa208sha256(200,$password, $salt,$opslimit,$memlimit);
error_reporting($old_error_level);
\Sodium\memzero($password);
return substr(bin2hex($key),0,$keysize);
// hash the password and return an ASCII string suitable for storage
}else{*/
//($password, $salt, $N, $r, $p, self::$_keyLength)
//Use of Zend framework fallback
return bin2hex(Scrypt::calc($password, $salt,$opslimit,$memlimit,$out_len,$keysize));
//}
}
}
