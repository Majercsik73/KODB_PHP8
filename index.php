<?php 
    // 1.Mellékhatás Request query paraméterek beolvasása
    $value = (int)($_GET['mennyit'] ?? 12);
    $sourceCurrency = $_GET['mirol'] ?? 'USD';
    $targetCurrency = $_GET['mire'] ?? 'HUF';

    //2.Mellékhatás átváltási ráta beolvasása
    $content = file_get_contents("https://kodbazis.hu/api/exchangerates?base=".$sourceCurrency);
    //var_dump($content);
    $decoded = json_decode($content, true);
    //var_dump($decoded);

    //3. Számítás
    $eredmeny = $decoded['rates'][$targetCurrency] * $value;
    //echo $eredmeny;

    //4. Valuta adatok beolvasása saját file-ból
    $currencies = json_decode(file_get_contents("./currencies.json"), true);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" />
</head>
    <title>Kódbázis_PHP8_Valutaváltó</title>
</head>
<body>
    <br />
    <h1 class="text-center" style="color:red" >Kódbázis Valutaváltó</h1>
    <div class="card w-25 m-auto p-3">
        <form action="">
            <input class="form-control mb-2" type="number" name="mennyit" value="<?php echo $value; ?>">

            <select class="form-control mb-2" name="mirol">
                <?php foreach($currencies as $currency): ?>
                    <option value="<?php echo $currency['label']; ?>" <?php echo $sourceCurrency === $currency['label'] ? 'selected' : ''?>>
                        <?php echo $currency['name'];?> <p><?php echo $currency['symbol']?>
                    </option>
                <?php endforeach; ?>
            </select>

            <h1 class="text-center">
                <?php echo $eredmeny;?>
            </h1>

            <select class="form-control mb-2" name="mire">
                <?php foreach($currencies as $currency): ?>
                    <option value="<?php echo $currency['label']; ?>" <?php echo $targetCurrency === $currency['label'] ? 'selected' : ''?>>
                        <?php echo $currency['name'];?> <p><?php echo $currency['symbol']?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <input type="submit" class="btn btn-primary form-control">
            
        </form>
    </div>
</body>
</html>