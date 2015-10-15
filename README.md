# formfile
parses the $_FILES array into an object

## usage

``` php
<?php
	
use scipper\Formfile\Formparser;
	
$formparser = new Formparser();
$formparser->parse();
	  
foreach($formparser->getFormfiles() as $file) {
  try {
    $path = $file->save("/some/where/");
  } catch(FormfileException $e) {
    error_log($e->getMessage());
  }
}
```
