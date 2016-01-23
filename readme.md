```
____   _________________________   ________ ___________
\   \ /   /\_   _____/\______   \ /  _____/ \_   _____/
 \   Y   /  |    __)_  |       _//   \  ___  |    __)_ 
  \     /   |        \ |    |   \\    \_\  \ |        \ 2016 VERGE
   \___/   /_______  / |____|_  / \______  //_______  /
                   \/         \/         \/         \/ 
```
# php-verge

A basic PHP library to talk to a VERGEd daemon to get you started in your VERGE project!

All of the end points of the API are not implemented, it is currently focused on account and moving of coins. I'm trying to make sure the library is documented and includes examples so its easy to use before being complete.  Patches are welcome.


## Requirements

Requires **VERGEd** to already be installed and running on your local server or reachable by your server.  

Get the VERGEd source from: https://github.com/vergecurrency/verge

compiling the coin is as easy as going into the ~/verge/src directory and typing (after you have dependencies installed):
git clone https://github.com/vergecurrency/verge
cd verge
cd src
make -f makefile.unix

## Usage:

Example use, see examples.php for more

```
require "./verge.php";

$config = array(
    'user' => 'vergerpcuser',
    'pass' => 'rpcpassword',
    'host' => '127.0.0.1',
    'port' => '20102' );

// create client connection
$verge = new verge( $config );

// create a new address
$address = $verge->get_address( 'vergeDEV' );
print( $address );

// check balance 
print( "vergeDEV: " . $verge->get_balance( 'vergeDEV' ) );

// send money externally (withdraw?)
$verge->send( 'vergeDEV', 'DPNC2H2pYUCSebQ992GyeRTRuWw3hCTBwD', 10000 );

```




Forked from library created by Marcus Kazmierczak, http://mkaz.com/


