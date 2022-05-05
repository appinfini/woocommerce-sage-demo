<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="format-detection" content="telephone=no">
	<title>{{ bloginfo('name') }}</title>
    <link rel="icon" type="image/svg+xml" sizes="16x16" href="@asset('images/favicon.ico')">
    @php wp_head() @endphp
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
	<link rel="stylesheet" type="text/css" href="{{ get_template_directory_uri() }}/resources/styles/slick.css">
	<link rel="stylesheet" type="text/css" href="{{ get_template_directory_uri() }}/resources/styles/style.css">
	<link rel="stylesheet" type="text/css" href="{{ get_template_directory_uri() }}/resources/styles/aos.css">
</head>
<body @php body_class() @endphp>
	<header x-data="{ isOpen: false }" class="bg-white border-b-4 border-gradient relative">
		<div class="container flex flex-wrap justify-between py-8">
			<a href="{{ home_url('/') }}" class="flex">
				<img src="@asset('images/logo.svg')" width="140" height="73" alt="Medical">
			</a>
			<div x-data="{dropdownMenu: false}" class="flex items-center md:order-2 relative">
				<span class="border-l border-gray-200 pl-4">
					<button @click="dropdownMenu = ! dropdownMenu" :class="{ 'text-blue-100': dropdownMenu }" type="button" class="flex items-center text-sm font-bold text-gray-100 hover:text-blue-100" id="user-menu-button" :aria-expanded="dropdownMenu ? 'true' : 'false'">
						<span class="relative inline-block rounded-full text-red-50">
							<svg class="w-7 h-7 md:w-6 md:h-6" aria-hidden="true" focusable="false" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M11.652 14.001C14.0992 14.001 16.083 12.0172 16.083 9.57001C16.083 7.12283 14.0992 5.13901 11.652 5.13901C9.20482 5.13901 7.22099 7.12283 7.22099 9.57001C7.22099 12.0172 9.20482 14.001 11.652 14.001Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M18.4599 19.729C16.622 17.9836 14.1842 17.0104 11.6495 17.0104C9.11486 17.0104 6.6769 17.9836 4.83897 19.729" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M11.653 22.306C17.5365 22.306 22.306 17.5365 22.306 11.653C22.306 5.76951 17.5365 1 11.653 1C5.76951 1 1 5.76951 1 11.653C1 17.5365 5.76951 22.306 11.653 22.306Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="hidden absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-50 z-2"></span>
						</span>
						<span class="ml-3 text-inherit hidden lg:inline-block">My account</span>
					</button>
				</span>
				<div x-show="dropdownMenu" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" @click.outside="dropdownMenu = false" class="absolute top-full right-0 z-50 w-60 list-none bg-white rounded-[10px] shadow-mx" id="user-menu">
					<div class="py-4 px-4 bg-gray-400 rounded-t-[10px]">
						<span class="block text-sm font-bold text-gray-100 truncate">stefano.tiller@gmail.com</span>
					</div>
					<ul class="list-none divide-y divide-gray-400">
						<li>
							<a href="#" class="block py-3 px-4 text-xs font-semibold text-gray-200 hover:text-gray-100 hover:bg-gray-400">My settings</a>
						</li>
						<li>
							<a href="#" class="block py-3 px-4 text-xs font-semibold text-gray-200 hover:text-gray-100 hover:bg-gray-400">My videos</a>
						</li>
						<li>
							<a href="#" class="block py-3 px-4 text-xs font-semibold text-gray-200 hover:text-gray-100 hover:bg-gray-400 rounded-b-[10px]">Logout</a>
						</li>
					</ul>
				</div>
				<button @click="isOpen = !isOpen" :class="{ 'text-blue-100': isOpen }" :aria-expanded="isOpen ? 'true' : 'false'" class="menu-toggler inline-flex items-center p-1 ml-3 text-sm text-gray-100 hover:text-blue-100 rounded-lg md:hidden hover:bg-transparent focus:outline-none focus:ring-0 focus:text-blue-100 focus:bg-white" type="button" aria-controls="mobile-menu">
					<span class="sr-only">Open main menu</span>
					<svg x-show="!isOpen" class="w-6 h-6" width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 1H17.063" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M1 8.079H17.063" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M1 15.158H9.381" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<svg x-show="isOpen" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
				</button>
			</div>
			<nav x-bind:class="! isOpen ? 'hidden' : ''" class="nav fixed md:static left-0 bg-slate-50 z-10 overflow-y-auto md:overflow-y-visible md:bg-transparent justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile-menu">
				<ul class="flex flex-col mt-6 pb-6 md:pb-0 md:flex-row md:space-x-4 lg:space-x-14 md:mt-0 text-base md:text-[15px] font-bold">
					<li class="dropdown">
						<a href="#"
							class="block py-1 px-4 md:p-0 md:hover:bg-transparent text-blue-100 transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-blue-100">PRODUCTS</a>
						<div
							class="md:hidden submenu pb-6 md:absolute z-40 md:top-full md:left-0 md:right-0 w-full md:py-4 md:bg-gradient-to-r from-[#1f557a] to-[#638ba0]">
							<div class="md:container md:px-4 px-0">
								<ul
									class="list-none md:flex md:flex-row md:justify-center md:space-x-4 lg:space-x-8 font-medium text-sm md:text-[13px]">
									<li>
										<a href="eyeview.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">eyeView</a>
									</li>
									<li>
										<a  href="myeyes.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">eyeCare</a>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<li class="dropdown">
						<a href="#"
							class="block py-1 px-4 md:p-0 md:hover:bg-transparent text-blue-100 transition-colors duration-200 transform md:border-b-2 md:border-blue-100 md:hover:border-blue-100">PHYSICIANS</a>
						<div
							class="{{ is_front_page() ? 'submenu' : 'md:hidden' }} pb-6 md:absolute z-40 md:top-full md:left-0 md:right-0 w-full md:py-4 md:bg-gradient-to-r from-[#1f557a] to-[#638ba0]">
							<div class="md:container md:px-4 px-0">
								<ul
									class="list-none md:flex md:flex-row md:justify-center md:space-x-4 lg:space-x-8 font-medium text-[13px]">
									<li>
										<a href="clinical-benefits.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">Clinical benefits</a>
									</li>
									<li>
										<a href="surgery.html" aria-current="page" class="block py-2 px-4 md:p-0 md:hover:bg-transparent text-white bg-blue-100 md:bg-transparent md:text-white transition-colors duration-200 transform md:border-b-2 md:border-white md:hover:border-white md:uppercase">Surgery</a>
									</li>
									<li>
										<a href="patient-management.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">Patient Management</a>
									</li>
									<li>
										<a href="publications.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">Publications</a>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<li class="dropdown">
						<a href="#"
							class="block py-1 px-4 md:p-0 md:hover:bg-transparent text-blue-100 transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-blue-100">PATIENTS</a>
						<div
							class="md:hidden submenu pb-6 md:absolute z-40 md:top-full md:left-0 md:right-0 w-full md:py-4 md:bg-gradient-to-r from-[#1f557a] to-[#638ba0]">
							<div class="md:container md:px-4 px-0">
								<ul
									class="list-none md:flex md:flex-row md:justify-center md:space-x-4 lg:space-x-8 font-medium text-[13px]">
									<li>
										<a href="patient-benefits.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">Patient Benefits</a>
									</li>
									<li>
										<a href="mri-safety.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">MRI Safety</a>
									</li>
									<li>
										<a href="testimonials.html" class="block py-2 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 md:text-white transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-white md:uppercase">Testimonials</a>
									</li>
								</ul>
							</div>
						</div>
					</li>
					<li>
						<a href="news.html" class="block py-1 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-blue-100">NEWS</a>
					</li>
					<li>
						<a href="contact.html" class="block py-1 px-4 md:p-0 hover:bg-gray-400 md:hover:bg-transparent text-blue-100 transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-blue-100">CONTACT</a>
					</li>
				</ul>
			</nav>
		</div>
	</header><!-- /.header -->