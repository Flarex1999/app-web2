<?php
namespace App\Controllers;
use App\Models\Db_model;
use CodeIgniter\Exceptions\PageNotFoundException;
class Accueil extends BaseController
{
   public function __construct()
{

	//..
}

  public function afficher()
 {
 $model = model(Db_model::class);
 $data['id'] = $model->get_news();
 return view('templates/haut')
 .view('menu_visiteur', $data)
   . view('affichage_accueil')
   . view('templates/bas');
 }
}
?>
