<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
	public function index(){
		
		// $userModel = new UserModel($db);
		// $users = $userModel->findAll();
		//$users = $userModel->where('nombre','gaston')->findAll();

		// $data = [
		// 	'nombre' => 'alfredo',
		// 	'apellido' => 'gallardo',
		// 	'edad' => 50
		// ];

		// $userModel->insert($data);

		/*$data = [
			'iduser' => 1,
			'nombre' => 'tongas'
		];
		$userModel->save($data);*/

		//$userModel->delete([4,5]);

		// $data = [
		// 	'nombre' => 'tongas_@',
		// 	'apellido' => 'perez',
		// 	'edad' => 80
		// ];
		// if(!$userModel->insert($data)){
		// 	var_dump($userModel->errors());
		// }

		// $planeModel = new PlaneModel($db);

		// $planes = $planeModel->findAll();

		// $planesD = array('planesD'=>$planes);

		// return view('inicio',$planesD);

		// echo 'HELLO WORLD!!';
		// $this->helloWorld('Tongas',234);

		$data['mydata1'] = 'testing1';
		$data['mydata2'] = 'testing2';
		$data['mydata3'] = 'testing3';
		$data['mydata4'] = 'testing4';

		return view('form',$data);

	}

	public function helloWorld($x,$y){

		echo 'Message from helloWorld function!';
		echo $x.' '.$y;
	}
}
