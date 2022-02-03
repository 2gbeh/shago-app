<?PHP
Context::set(
	'Page not found',
	'404.php'
);
Context::set(
	'About Us',
	'about.php'
);
Context::set(
	'My Account',
	'account.php'
	// update profile, change password, delivery address, submut ticket, dashboard, my orders, sell on ShagoApp	
);
Context::set(
	'Advertise Here',
	'advertise.php'
);
Context::set(
	'My Cart',
	'cart.php'
);
Context::set(
	'All Categories',
	'categories.php'
	// trending, sorted
);
Context::set(
	'Dashboard',
	'dashboard.php'
);
Context::set(
	'Delivery Method',
	'delivery.php'
);
Context::set(
	null,
	'index.php'
);
Context::set(
	'My Orders',
	'orders.php'
);
Context::set(
	'Payment Method',
	'payment.php'
);
Context::set(
	'Preview | ' . $_GET['p'],
	'product.php'
);
Context::set(
	'Search | ' . $_GET['k'],
	'products.php'
);
Context::set(
	'Account Settings',
	'settings.php'
	// update profile, change password, delivery address, 
);
Context::set(
	'Log in',
	'sign_in.php'
);
Context::set(
	'Retrieve Password',
	'sign_in_help.php'
);
Context::set(
	'Create an account',
	'sign_up.php'
);
Context::set(
	'Order Summary',
	'summary.php'
);
Context::set(
	'Submit Ticket',
	'ticket.php'
);
Context::set(
	'View Tickets',
	'tickets.php'
);
Context::set(
	'Vendor | ' . $_GET['v'],
	'vendor.php'
);
Context::set(
	'Our Vendors',
	'vendors.php'
);

Context::set(
	'Add Product',
	'add_product.php'
);

Context::set(
	'View Products',
	'view_products.php'
);

//Context::map();
extract(Context::get());
?>



