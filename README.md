Caching html content in static files

using:

1. Create dir file_cache
2. Create file file_cache.flag(enable or disable file_cache)
3. Add code to your index.php file:

        <?php
             require_once 'file_cache_in.php';

	     // ------------------------------------- //
             require(dirname(__FILE__).'/config/config.inc.php');
             Dispatcher::getInstance()->dispatch();
             // ------------------------------------- //

	     require_once 'file_cache_out.php';
	?>
