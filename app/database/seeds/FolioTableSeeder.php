<?php 

/**
* 
*/
class FolioTableSeeder extends Seeder
{
	
	public function run()
	{
		$folio = new Folio;
		$folio->folio = 0;

		if(! $folio->save()) {
      Log::info('Unable to create folio '.$folio->folio, (array)$folio->errors());
    } else {
      Log::info('Created folio "'.$folio->folio.'"');
    }
	}
}