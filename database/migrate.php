<?php
declare(strict_types=1);require_once dirname(__DIR__).'/app/bootstrap.php';try{(new Migrator())->migrate();echo "Migrations completed successfully.\n";}catch(Throwable $e){fwrite(STDERR,"Migration failed: ".$e->getMessage()."\n");exit(1);}
