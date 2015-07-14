<?php # controllers/newbill.php

# Logic

if(Input::posted()){

	$bill = new Bill();

	$bill->fill(Input::all());
	$bill->splitcost = $bill->cost / 5;

	if ($_FILES) {
		$files = Upload::to_folder('assets/uploads/');

		if ($_FILES[0]['error_message'] == false) {
			$bill->image = $files[0]['filepath'];
		}
	}

	$bill->save();

	$users = new Users_Collection();
	$users->get();

	foreach ($users->items as $user) {

		$account = new Account();
		$account->user_id = $user->id;
		$account->bill_id = $bill->id;
		$account->save();

	}

	URL::redirect('/admin');
}

$title = 'New Bill';

# Views

include VIEWS.'header.php';
include VIEWS.'bill_form.php';
include VIEWS.'footer.php';