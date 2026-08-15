<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MySql db connection</title>
</head>
<body>
    <div>
       <?
            try {
                $database = \DB::connection()->getDatabaseName();
                echo "successful DB connection: " . $database;
            } catch (\Exception $e) {
                echo "DB connection failed: " . $e->getMessage();
            }
        ?>
    </div>
    
</body>
</html>