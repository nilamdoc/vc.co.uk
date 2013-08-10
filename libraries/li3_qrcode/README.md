li3_qrcode
==========

QRCode for Lithium. 

Installing
====
The installation process is simple, just place the source code in the libraries-directory and create a li3_qrcode directory:

    $ cd /path/to/app/libraries
    $ git clone git@github.com:nilamdoc/li3_qrcode.git

Li3_qrcode is a plugin, you can install it in your application as

    Libraries::add('li3_qrcode');
	
Usage
====

   In your view:
   
    use li3_qrcode\extensions\action\Qrcode;
    $qrcode->png('This is a test QR code', QR_OUTPUT_DIR.'test.png', 'H', 7, 2);
    <img src="<?=QR_OUTPUT_RELATIVE_DIR;?>test.png">

Additional Configuration:
====
Modify QRconfig.php for changing the 

    QR_OUTPUT_DIR
	QR_OUTPUT_RELATIVE_DIR
	