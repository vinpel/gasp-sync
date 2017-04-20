<?php

namespace common\tests\unit\models;

use Yii;
use common\models\LoginForm;
use common\fixtures\User as UserFixture;
use \Codeception\Util\Debug;
/**
* Login form test
*/
class CryptoHkdfTest extends \Codeception\Test\Unit
{
  /**
  * @var \common\tests\UnitTester
  */
  protected $tester;


  /**
  * A.1.  Test Case 1
  */
  public function testHkdfTestCase1(){
    $hash = 'sha256';
    $IKM  = "\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b";// (22 octets)
    $salt = "\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c";// (13 octets)
    $info = "\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf7\xf8\xf9";// (10 octets)
    $L    = 42;

    $OKM  = '3cb25f25faacd57a90434f64d0362f2a2d2d0a90cf1a5a4c5db02d56ecc4c5bf34007208d5b887185865';// (42 octets)

    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);

    $this->assertNotEquals($R,false);

    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }
  /**
  * A.2.  Test Case 2
  * Test with SHA-256 and longer inputs/outputs
  */
  public function testHkdfTestCase2(){
    $hash = 'sha256';
    $IKM  = "\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1a\x1b\x1c\x1d\x1e\x1f\x20\x21\x22\x23\x24\x25\x26\x27\x28\x29\x2a\x2b\x2c\x2d\x2e\x2f\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x3a\x3b\x3c\x3d\x3e\x3f\x40\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4a\x4b\x4c\x4d\x4e\x4f"; // (80 octets)
    $salt = "\x60\x61\x62\x63\x64\x65\x66\x67\x68\x69\x6a\x6b\x6c\x6d\x6e\x6f\x70\x71\x72\x73\x74\x75\x76\x77\x78\x79\x7a\x7b\x7c\x7d\x7e\x7f\x80\x81\x82\x83\x84\x85\x86\x87\x88\x89\x8a\x8b\x8c\x8d\x8e\x8f\x90\x91\x92\x93\x94\x95\x96\x97\x98\x99\x9a\x9b\x9c\x9d\x9e\x9f\xa0\xa1\xa2\xa3\xa4\xa5\xa6\xa7\xa8\xa9\xaa\xab\xac\xad\xae\xaf"; // (80 octets)
    $info = "\xb0\xb1\xb2\xb3\xb4\xb5\xb6\xb7\xb8\xb9\xba\xbb\xbc\xbd\xbe\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf7\xf8\xf9\xfa\xfb\xfc\xfd\xfe\xff"; // (80 octets)
    $L    = 82;

    $OKM  = 'b11e398dc80327a1c8e7f78c596a49344f012eda2d4efad8a050cc4c19afa97c59045a99cac7827271cb41c65e590e09da3275600c2f09b8367793a9aca3db71cc30c58179ec3e87c14c01d5c1f3434f1d87'; // (82 octets)

    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);

    $this->assertNotEquals($R,false);
    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }

  /**
  * A.3.  Test Case 3
  * Test with SHA-256 and zero-length salt/info
  */
  public function testHkdfTestCase3(){
    $hash = 'sha256';
    $IKM  = "\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b";// (22 octets)
    $salt = null; // (0 octets)
    $info = null; //(0 octets)
    $L    = 42;

    $OKM  = '8da4e775a563c18f715f802a063c5a31b8a11f5c5ee1879ec3454e5f3c738d2d9d201395faa4b61a96c8';// (42 octets)
    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);

    $this->assertNotEquals($R,false);
    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }

  /**
  * A.4.  Test Case 4
  * Basic test case with SHA-1
  */
  public function testHkdfTestCase4(){
    $hash = 'sha1';
    $IKM  = "\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b";// (11 octets)
    $salt = "\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c"; // (13 octets)
    $info = "\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf7\xf8\xf9"; //(10 octets)
    $L    = 42;
    $OKM  = '085a01ea1b10f36933068b56efa5ad81'.
    'a4f14b822f5b091568a9cdd4f155fda2'.
    'c22e422478d305f3f896'; //(42 octets)

    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);



    $this->assertNotEquals($R,false);
    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }

  /**
  * A.5.  Test Case 5
  * Test with SHA-1 and longer inputs/outputs
  */
  public function testHkdfTestCase5(){
    $hash = 'sha1';

    $IKM  = "\x00\x01\x02\x03\x04\x05\x06\x07\x08\x09\x0a\x0b\x0c\x0d\x0e\x0f\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19\x1a\x1b\x1c\x1d\x1e\x1f\x20\x21\x22\x23\x24\x25\x26\x27\x28\x29\x2a\x2b\x2c\x2d\x2e\x2f\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x3a\x3b\x3c\x3d\x3e\x3f\x40\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4a\x4b\x4c\x4d\x4e\x4f";// (80 octets)
    $salt = "\x60\x61\x62\x63\x64\x65\x66\x67\x68\x69\x6a\x6b\x6c\x6d\x6e\x6f\x70\x71\x72\x73\x74\x75\x76\x77\x78\x79\x7a\x7b\x7c\x7d\x7e\x7f\x80\x81\x82\x83\x84\x85\x86\x87\x88\x89\x8a\x8b\x8c\x8d\x8e\x8f\x90\x91\x92\x93\x94\x95\x96\x97\x98\x99\x9a\x9b\x9c\x9d\x9e\x9f\xa0\xa1\xa2\xa3\xa4\xa5\xa6\xa7\xa8\xa9\xaa\xab\xac\xad\xae\xaf";// (80 octets)
    $info = "\xb0\xb1\xb2\xb3\xb4\xb5\xb6\xb7\xb8\xb9\xba\xbb\xbc\xbd\xbe\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf7\xf8\xf9\xfa\xfb\xfc\xfd\xfe\xff";// (80 octets)
    $L    = 82;

    $OKM  = '0bd770a74d1160f7c9f12cd5912a06eb'.
    'ff6adcae899d92191fe4305673ba2ffe'.
    '8fa3f1a4e5ad79f3f334b3b202b2173c'.
    '486ea37ce3d397ed034c7f9dfeb15c5e'.
    '927336d0441f4c4300e2cff0d0900b52'.
    'd3b4';// (82 octets)
    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);

    $this->assertNotEquals($R,false);
    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }

  /**
  * A.6.  Test Case 6
  * Test with SHA-1 and zero-length salt/info
  */
  public function testHkdfTestCase6(){
    $hash = 'sha1';
    $IKM  = "\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b\x0b";// (22 octets)
    $salt = '';//(0 octets)
    $info = '';//(0 octets)
    $L    = 42;
    $OKM  = '0ac1af7002b3d761d1e55298da9d0506'.
    'b9ae52057220a306e07b6b87e8df21d0'.
    'ea00033de03984d34918'; // (42 octets)

    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);

    $this->assertNotEquals($R,false);
    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }

  /**
  *   A.7.  Test Case 7
  *   Test with SHA-1, salt not provided (defaults to HashLen zero octets),
  * zero-length info
  */
  public function testHkdfTestCase7(){
    $hash = 'sha1';
    $IKM  = "\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c\x0c";// (22 octets)
    $salt = null;//(0 octets)
    $info = '';//(0 octets)
    $L    = 42;

    $OKM  = '2c91117204d745f3500d636a62f64f0a'.
    'b3bae548aa53d423b0d1f27ebba6f5e5'.
    '673a081d70cce7acfc48'; // (42 octets)

    $R = \yii::$app->crypto->hkdf($hash, $IKM, $L,$info, $salt);

    $this->assertNotEquals($R,false);
    Debug::debug("\n".$OKM."\n".bin2hex($R));
    $this->assertEquals(bin2hex($R),$OKM);
  }
}
