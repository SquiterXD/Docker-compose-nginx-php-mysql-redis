<?php 

namespace App\Http\Controllers\IR\Ajax\Repositories\Interfaces;

interface ExtendGasStationsInterface {
	public function getAll(string $year, string $typeCode, string $groupCode, string $status);
	public function	getByID(int $id);
	public function	store(array $detail);
	public function	update(int $id, array $detail, string $flag);
	public function	destroy(int $id);
}