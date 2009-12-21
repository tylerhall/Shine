<?PHP
    require 'includes/master.inc.php';

    $app = new Application();
    $app->select($_POST['item_number']); // custom
    if(!$app->ok())
    {
        error_log("Application {$_POST['item_name']} {$_POST['item_number']} not found!");
        exit;
    }

    $o = new Order();
    $o->payer_email       = $_POST['CustomerEmail'];
    $o->first_name        = $_POST['CustomerFirstName'];
    $o->last_name         = $_POST['CustomerLastName'];
    $o->txn_id            = $_POST['OrderReference'];
    $o->item_name         = $_POST['item_name']; // custom
    $o->residence_country = $_POST['AddressCountry'];
    $o->quantity          = $_POST['quantity']; // custom
    $o->mc_currency       = $_POST['mc_currency']; // custom
    $o->payment_gross     = preg_replace('/[^0-9.]/', '', $_POST['payment_gross']); // custom
    $o->mc_gross          = $o->payment_gross;

    $o->app_id = $app->id;
    $o->dt = dater();
    $o->type = 'FastSpring';
    $o->insert();

    $o->generateLicense();
    $o->emailLicense();

    // These are the fields and values you'll need to setup in FastSpring's
    // remote notification fulfillment option.

    // AddressCountry       #{order.address.country}
    // CustomerEmail        #{order.customer.email}
    // CustomerFirstName    #{order.customer.firstName}
    // CustomerLastName     #{order.customer.lastName}
    // OrderReference       #{order.reference}
    // item_name            #{orderItem.productName}
    // item_number          3 <-- this is the Shine ID number of your product
    // mc_currency          #{order.currency}
    // payment_gross        #{orderItem.priceTotalUSD.value}
    // quantity             #{orderItem.quantity}
