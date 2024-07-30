<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EntrustSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Dictionary : 
     *              01- Roles 
     *              02- Users
     *              03- AttachRoles To  Users
     *              04- Create random customer and  AttachRole to customerRole
     * 
     * 
     * @return void
     */
    public function run()
    {

        //create fake information  using faker factory lab 
        $faker = Factory::create();
        $specializations = Specialization::query()->pluck('id');


        //------------- 01- Roles ------------//
        //adminRole
        $adminRole = new Role();
        $adminRole->name         = 'admin';
        $adminRole->display_name = 'User Administrator'; // optional
        $adminRole->description  = 'User is allowed to manage and edit other users'; // optional
        $adminRole->allowed_route = 'admin';
        $adminRole->save();

        //supervisorRole
        $supervisorRole = Role::create([
            'name' => 'supervisor',
            'display_name' => 'User Supervisor',
            'description' => 'Supervisor is allowed to manage and edit other users',
            'allowed_route' => 'admin',
        ]);


        //customerRole
        $customerRole = new Role();
        $customerRole->name         = 'customer';
        $customerRole->display_name = 'Project Customer'; // optional
        $customerRole->description  = 'Customer is the customer of a given project'; // optional
        $customerRole->allowed_route = null;
        $customerRole->save();

        //instructorRole
        $instructorRole = new Role();
        $instructorRole->name         = 'instructor';
        $instructorRole->display_name = 'Document instructor';
        $instructorRole->description  = 'instructor is the person who  instruct Documents';
        $instructorRole->allowed_route = null;
        $instructorRole->save();




        //------------- 02- Users  ------------//
        // Create Admin
        $admin = new User();
        $admin->first_name = 'Admin';
        $admin->last_name = 'System';
        $admin->username = 'admin';
        $admin->email = 'admin@gmail.com';
        $admin->email_verified_at = now();
        $admin->mobile = '00967772036131';
        $admin->password = bcrypt('123123123');
        $admin->user_image = 'avator.svg';
        $admin->status = 1;
        $admin->remember_token = Str::random(10);
        $admin->save();

        // Create supervisor
        $supervisor = User::create([
            'first_name' => 'Supervisor',
            'last_name' => 'System',
            'username' => 'supervisor',
            'email' => 'supervisor@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036132',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        // Create customer
        $customer = User::create([
            'first_name' => 'Khaleel',
            'last_name' => 'Raweh',
            'username' => 'khaleel',
            'email' => 'khaleelvisa@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036133',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        // Create customer
        $customer2 = User::create([
            'first_name' => 'naser',
            'last_name' => 'naser',
            'username' => 'naser',
            'email' => 'naser@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036136',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);

        // create instructor
        $instructor = User::create([
            'first_name' => 'instructor',
            'last_name' => 'person',
            'username' => 'instructor',
            'email' => 'instructor@gmail.com',
            'email_verified_at' => now(),
            'mobile' => '00967772036134',
            'password' => bcrypt('123123123'),
            'user_image' => 'avator.svg',
            'status' => 1,
            'remember_token' => Str::random(10),
        ]);



        //------------- 03- AttachRoles To  Users  ------------//
        $admin->attachRole($adminRole);
        $admin->attachRole($instructorRole);
        $supervisor->attachRole($supervisorRole);
        $customer->attachRole($customerRole);
        $customer2->attachRole($customerRole);
        $instructor->attachRole($instructorRole);
        $instructor->specializations()->sync($specializations->random(1, 3));


        //------------- 05- Permission  ------------//
        //manage main dashboard page
        $manageMain = Permission::create(['name' => 'main', 'display_name' => ['ar' =>  'الرئيسية', 'en'   =>  'Main'], 'route' => 'index', 'module' => 'index', 'as' => 'index', 'icon' => 'ri-dashboard-line', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '1']);
        $manageMain->parent_show = $manageMain->id;
        $manageMain->save();


        //manage Document categories
        $manageDocumentCategories = Permission::create(['name' => 'manage_document_categories', 'display_name' => ['ar'    =>  'إدارة الوثائق',   'en'    =>  'Manage Documents'], 'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.index', 'icon' => 'fas fa-align-justify', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '5',]);
        $manageDocumentCategories->parent_show = $manageDocumentCategories->id;
        $manageDocumentCategories->save();
        $showDocumentCategories    =  Permission::create(['name' => 'show_document_categories', 'display_name'       =>    ['ar'   =>  'تصنيف الوثائق',   'en'    =>  ' Categories'],   'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.index', 'icon' => 'fas fa-align-justify', 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createDocumentCategories  =  Permission::create(['name' => 'create_document_categories', 'display_name'     =>    ['ar'   =>  'إضافة تصنيف الوثيقة',   'en'    =>  'Add Document Category'],    'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.create', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentCategories =  Permission::create(['name' => 'display_document_categories', 'display_name'    =>    ['ar'   =>  ' عرض تصنيف الوثيقة',   'en'    =>  'Display Document Category'],    'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.show', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentCategories  =  Permission::create(['name' => 'update_document_categories', 'display_name'     =>    ['ar'   =>  'تعديل تصنيف الوثيقة',   'en'    =>  'Edit Document Category'],    'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.edit', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentCategories  =  Permission::create(['name' => 'delete_document_categories', 'display_name'     =>    ['ar'   =>  'حذف تصنيف الوثيقة',   'en'    =>  'Delete Document Category'],    'route' => 'document_categories', 'module' => 'document_categories', 'as' => 'document_categories.destroy', 'icon' => null, 'parent' => $manageDocumentCategories->id, 'parent_original' => $manageDocumentCategories->id, 'parent_show' => $manageDocumentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);


        //manage Document Types
        $manageDocumentTypes = Permission::create(['name' => 'manage_document_types', 'display_name' => ['ar'    =>  ' انواع الوثائق',   'en'    =>  'Document Types'], 'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.index', 'icon' => 'fas fa-align-justify', 'parent' => $manageDocumentCategories->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '10',]);
        $manageDocumentTypes->parent_show = $manageDocumentTypes->id;
        $manageDocumentTypes->save();
        $showDocumentTypes    =  Permission::create(['name' => 'show_document_types', 'display_name'       =>    ['ar'   =>  'انواع الوثائق',   'en'    =>  ' Document Types'],   'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.index', 'icon' => 'fas fa-align-justify', 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createDocumentTypes  =  Permission::create(['name' => 'create_document_types', 'display_name'     =>    ['ar'   =>  'إضافة نوع وثيقة',   'en'    =>  'Add Document Type'],    'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.create', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayDocumentTypes =  Permission::create(['name' => 'display_document_types', 'display_name'    =>    ['ar'   =>  ' عرض نوع وثيقة',   'en'    =>  'Display Document Type'],    'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.show', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateDocumentTypes  =  Permission::create(['name' => 'update_document_types', 'display_name'     =>    ['ar'   =>  'تعديل نوع وثيقة',   'en'    =>  'Edit Document Type'],    'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.edit', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteDocumentTypes  =  Permission::create(['name' => 'delete_document_types', 'display_name'     =>    ['ar'   =>  'حذف نوع وثيقة',   'en'    =>  'Delete Document Type'],    'route' => 'document_types', 'module' => 'document_types', 'as' => 'document_types.destroy', 'icon' => null, 'parent' => $manageDocumentTypes->id, 'parent_original' => $manageDocumentTypes->id, 'parent_show' => $manageDocumentTypes->id, 'sidebar_link' => '0', 'appear' => '0']);



        //Customers
        $manageCustomers = Permission::create(['name' => 'manage_customers', 'display_name' => ['ar'    =>  'إدارة المستخدمين',  'en' =>  'Manage Users'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user-cog', 'parent' => '0', 'parent_original' => '0',  'sidebar_link' => '1', 'appear' => '1', 'ordering' => '25',]);
        $manageCustomers->parent_show = $manageCustomers->id;
        $manageCustomers->save();
        $showCustomers   =  Permission::create(['name'  => 'show_customers', 'display_name'    => ['ar'   =>     'العملاء',   'en'    =>  'Customers'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.index', 'icon' => 'fas fa-user-graduate', 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCustomers =  Permission::create(['name'  => 'create_customers', 'display_name'    => ['ar'   =>      'إضافة عميل',   'en'    =>  'Add New Customer'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.create', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayCustomers =  Permission::create(['name' => 'display_customers', 'display_name'     => ['ar'   =>      'عرض عميل',   'en'    =>  'Dsiplay Customer'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.show', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCustomers  =  Permission::create(['name' => 'update_customers', 'display_name'     => ['ar'   =>      'تعديل عميل',   'en'    =>  'Edit Customer'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.edit', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCustomers =  Permission::create(['name'  => 'delete_customers', 'display_name'    => ['ar'   =>      'حذف عميل',   'en'    =>  'Delete Customer'], 'route' => 'customers', 'module' => 'customers', 'as' => 'customers.destroy', 'icon' => null, 'parent' => $manageCustomers->id, 'parent_original' => $manageCustomers->id, 'parent_show' => $manageCustomers->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Supervisor // we can hide suppervisor not to be in sidebar linke by  making in manage_supervisors 'sidebar_link' => '0'
        $manageSupervisors = Permission::create(['name' => 'manage_supervisors', 'display_name' => ['ar'    =>  'المشرفين',    'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageCustomers->id, 'parent_original' => '0', 'parent_show' => $manageCustomers->id, 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '30',]);
        $manageSupervisors->parent_show = $manageSupervisors->id;
        $manageSupervisors->save();
        $showSupervisors   =  Permission::create(['name' => 'show_supervisors', 'display_name'    =>  ['ar'   =>  'المشرفين',   'en'    =>  'Supervisors'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.index', 'icon' => 'fas fa-user-tie', 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createSupervisors =  Permission::create(['name' => 'create_supervisors', 'display_name'    =>  ['ar'   =>  'إضافة مشرف جديد',   'en'    =>  'Add Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.create', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displaySupervisors =  Permission::create(['name' => 'display_supervisors', 'display_name'    =>  ['ar'   =>  'عرض مشرف',   'en'    =>  'Dsiplay Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.show', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateSupervisors  =  Permission::create(['name' => 'update_supervisors', 'display_name'    =>  ['ar'   =>  'تعديل مشرف',   'en'    =>  'Edit Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.edit', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteSupervisors =  Permission::create(['name' => 'delete_supervisors', 'display_name'    =>  ['ar'   =>  'حذف مشرف',   'en'    =>  'Delete Supervisor'], 'route' => 'supervisors', 'module' => 'supervisors', 'as' => 'supervisors.destroy', 'icon' => null, 'parent' => $manageSupervisors->id, 'parent_original' => $manageSupervisors->id, 'parent_show' => $manageSupervisors->id, 'sidebar_link' => '0', 'appear' => '0']);







        //Countries
        $manageCountries = Permission::create(['name' => 'manage_countries', 'display_name' => ['ar'  =>  'إدارة البلدان',   'en'    =>  'Manage Countries'], 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.index', 'icon' => 'fas fa-globe', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '120',]);
        $manageCountries->parent_show = $manageCountries->id;
        $manageCountries->save();
        $showCountries   =  Permission::create(['name'     => 'show_countries', 'display_name'  => ['ar'   =>  'الدول',   'en'    =>  'Countries'], 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.index', 'icon' => 'fas fa-globe', 'parent' => $manageCountries->id, 'parent_original' => $manageCountries->id,  'parent_show' => $manageCountries->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCountries =  Permission::create(['name'     => 'create_countries', 'display_name'  => ['ar'   =>  'إضافة دولة',   'en'    =>  'Add Country'], 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.create', 'icon' => null, 'parent' => $manageCountries->id, 'parent_original' => $manageCountries->id,  'parent_show' => $manageCountries->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayCountries =  Permission::create(['name'     => 'display_countries', 'display_name'  => ['ar'   =>  'عرض بيانات الدولة',   'en'    =>  'Display Country'], 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.show', 'icon' => null, 'parent' => $manageCountries->id, 'parent_original' => $manageCountries->id,  'parent_show' => $manageCountries->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCountries  =  Permission::create(['name'     => 'update_countries', 'display_name'  => ['ar'   =>  'تعديل بيانات الدولة',   'en'    =>  'Edit Country'], 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.edit', 'icon' => null, 'parent' => $manageCountries->id, 'parent_original' => $manageCountries->id,  'parent_show' => $manageCountries->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCountries =  Permission::create(['name'     => 'delete_countries', 'display_name'  => ['ar'   =>  'حذف الدولة',   'en'    =>  'Delete Country'], 'route' => 'countries', 'module' => 'countries', 'as' => 'countries.destroy', 'icon' => null, 'parent' => $manageCountries->id, 'parent_original' => $manageCountries->id,  'parent_show' => $manageCountries->id, 'sidebar_link' => '0', 'appear' => '0']);

        //States
        $manageStates = Permission::create(['name' => 'manage_states', 'display_name' => ['ar' =>   'المحافظات',    'en'    =>  'States'], 'route' => 'states', 'module' => 'states', 'as' => 'states.index', 'icon' => 'fas fa-map-marker-alt', 'parent' =>  $manageCountries->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '125',]);
        $manageStates->parent_show = $manageStates->id;
        $manageStates->save();
        $showStates     =  Permission::create(['name' => 'show_states', 'display_name'    => ['ar'  =>  'المحافظات',    'en'    =>  'States'], 'route' => 'states', 'module' => 'states', 'as' => 'states.index', 'icon' => 'fas fa-map-marker-alt', 'parent' => $manageStates->id, 'parent_original' => $manageStates->id, 'parent_show' => $manageStates->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createStates   =  Permission::create(['name' => 'create_states', 'display_name'        =>  ['ar'   =>  'إضافة محافظة',   'en'    =>  'Create State'], 'route' => 'states', 'module' => 'states', 'as' => 'states.create', 'icon' => null, 'parent' => $manageStates->id, 'parent_original' => $manageStates->id, 'parent_show' => $manageStates->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayStates  =  Permission::create(['name' => 'display_states', 'display_name'       =>  ['ar'   =>  'عرض محافظة',   'en'    =>  'Display State'], 'route' => 'states', 'module' => 'states', 'as' => 'states.show', 'icon' => null, 'parent' => $manageStates->id, 'parent_original' => $manageStates->id, 'parent_show' => $manageStates->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateStates   =  Permission::create(['name' => 'update_states', 'display_name'        =>  ['ar'   =>  'تعديل محافظة',   'en'    =>  'Edit State'], 'route' => 'states', 'module' => 'states', 'as' => 'states.edit', 'icon' => null, 'parent' => $manageStates->id, 'parent_original' => $manageStates->id, 'parent_show' => $manageStates->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteStates   =  Permission::create(['name' => 'delete_states', 'display_name'        =>  ['ar'   =>  'حذف المحافظة',   'en'    =>  'Delete State'], 'route' => 'states', 'module' => 'states', 'as' => 'states.destroy', 'icon' => null, 'parent' => $manageStates->id, 'parent_original' => $manageStates->id, 'parent_show' => $manageStates->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Cities
        $manageCities = Permission::create(['name' => 'manage_cities', 'display_name' =>    ['ar'   =>  'المدن',   'en'    =>  'Cities'], 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.index', 'icon' => 'fas fa-university', 'parent' =>  $manageCountries->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '130',]);
        $manageCities->parent_show = $manageCities->id;
        $manageCities->save();
        $showCities     =  Permission::create(['name' => 'show_cities', 'display_name'          =>  ['ar'   =>  'المدن',           'en' =>  'Cities'], 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.index', 'icon' => 'fas fa-university', 'parent' => $manageCities->id, 'parent_original' => $manageCities->id, 'parent_show' => $manageCities->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createCities   =  Permission::create(['name' => 'create_cities', 'display_name'        =>  ['ar'   =>  'إضافة مدينة',     'en' =>  'Create City'], 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.create', 'icon' => null, 'parent' => $manageCities->id, 'parent_original' => $manageCities->id, 'parent_show' => $manageCities->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayCities  =  Permission::create(['name' => 'display_cities', 'display_name'       =>  ['ar'   =>  'عرض مدينة',       'en' =>  'Display City'], 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.show', 'icon' => null, 'parent' => $manageCities->id, 'parent_original' => $manageCities->id, 'parent_show' => $manageCities->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updateCities   =  Permission::create(['name' => 'update_cities', 'display_name'        =>  ['ar'   =>  'تعديل المدينة',   'en' =>  'Edit City'], 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.edit', 'icon' => null, 'parent' => $manageCities->id, 'parent_original' => $manageCities->id, 'parent_show' => $manageCities->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deleteCities   =  Permission::create(['name' => 'delete_cities', 'display_name'        =>  ['ar'   =>  'حذف المدينة',     'en' =>  'Delete City'], 'route' => 'cities', 'module' => 'cities', 'as' => 'cities.destroy', 'icon' => null, 'parent' => $manageCities->id, 'parent_original' => $manageCities->id, 'parent_show' => $manageCities->id, 'sidebar_link' => '0', 'appear' => '0']);

        //payment Categories
        $managePaymentCategories = Permission::create(['name' => 'manage_payment_categories', 'display_name' => ['ar'   =>  'إدارة تصنيف طرق الدفع',   'en'    =>  'payment Categories'], 'route' => 'payment_categories', 'module' => 'payment_categories', 'as' => 'payment_categories.index', 'icon' => 'fas fa-file-archive', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '0', 'appear' => '0', 'ordering' => '140',]);
        $managePaymentCategories->parent_show = $managePaymentCategories->id;
        $managePaymentCategories->save();
        $showPaymentCategories    =  Permission::create(['name' => 'show_payment_categories',  'display_name'   =>  ['ar'   =>  'تصنيف طرق الدفع',   'en'    =>  'Payment Categories'], 'route' => 'payment_categories', 'module' => 'payment_categories', 'as' => 'payment_categories.index', 'icon' => 'fas fa-file-archive', 'parent' => $managePaymentCategories->id, 'parent_original' => $managePaymentCategories->id, 'parent_show' => $managePaymentCategories->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPaymentCategories  =  Permission::create(['name' => 'create_payment_categories', 'display_name'  =>  ['ar'   =>  'إضافة تصيف طريقة دفع',   'en'    =>  'Create Payment Category'], 'route' => 'payment_categories', 'module' => 'payment_categories', 'as' => 'payment_categories.create', 'icon' => null, 'parent' => $managePaymentCategories->id, 'parent_original' => $managePaymentCategories->id, 'parent_show' => $managePaymentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPaymentCategories =  Permission::create(['name' => 'display_payment_categories', 'display_name' =>  ['ar'   =>  'عرض تصنيف طريقة دفع',   'en'    =>  'Display Payment Category'], 'route' => 'payment_categories', 'module' => 'payment_categories', 'as' => 'payment_categories.show', 'icon' => null, 'parent' => $managePaymentCategories->id, 'parent_original' => $managePaymentCategories->id, 'parent_show' => $managePaymentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePaymentCategories  =  Permission::create(['name' => 'update_payment_categories', 'display_name'  =>  ['ar'   =>  'تعديل تصنيف طريقة دفع',   'en'    =>  'Edit Payment Category'], 'route' => 'payment_categories', 'module' => 'payment_categories', 'as' => 'payment_categories.edit', 'icon' => null, 'parent' => $managePaymentCategories->id, 'parent_original' => $managePaymentCategories->id, 'parent_show' => $managePaymentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePaymentCategories  =  Permission::create(['name' => 'delete_payment_categories', 'display_name'  =>  ['ar'   =>  'حذف تصنيف طريقة دفع',   'en'    =>  'Delete Payment Category'], 'route' => 'payment_categories', 'module' => 'payment_categories', 'as' => 'payment_categories.destroy', 'icon' => null, 'parent' => $managePaymentCategories->id, 'parent_original' => $managePaymentCategories->id, 'parent_show' => $managePaymentCategories->id, 'sidebar_link' => '0', 'appear' => '0']);

        //Payment Methods
        $managePaymentMethods = Permission::create(['name' => 'manage_payment_methods', 'display_name' => ['ar' =>  'بوابات الدفع',    'en'    =>  'Payment Gateways'], 'route' => 'payment_methods', 'module' => 'payment_methods', 'as' => 'payment_methods.index', 'icon' => 'fas fa-dollar-sign', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '0', 'appear' => '1', 'ordering' => '145',]);
        $managePaymentMethods->parent_show = $managePaymentMethods->id;
        $managePaymentMethods->save();
        $showPaymentMethods   =  Permission::create(['name'  => 'show_payment_methods', 'display_name'          =>  ['ar'   =>  'بوابات الدفع',   'en'    =>  'Payment Gateways'], 'route' => 'payment_methods', 'module' => 'payment_methods', 'as' => 'payment_methods.index', 'icon' => 'fas fa-dollar-sign', 'parent' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPaymentMethods =  Permission::create(['name'  => 'create_payment_methods', 'display_name'        =>  ['ar'   =>  'إضافة بوابة دفع',   'en'    =>  'Create Payment Gateway'], 'route' => 'payment_methods/create', 'module' => 'payment_methods', 'as' => 'payment_methods.create', 'icon' => null, 'parent' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'sidebar_link' => '1', 'appear' => '0']);
        $displayPaymentMethods =  Permission::create(['name'  => 'display_payment_methods', 'display_name'      =>  ['ar'   =>  'عرض بوابة دفع',   'en'    =>  'Display Payment Gateway'], 'route' => 'payment_methods/{payment_methods}', 'module' => 'payment_methods', 'as' => 'payment_methods.show', 'icon' => null, 'parent' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePaymentMethods =  Permission::create(['name'  => 'update_payment_methods', 'display_name'        =>  ['ar'   =>  'تعديل  بوابة الدفع',   'en'    =>  'Edit Payment Gateway'], 'route' => 'payment_methods/{payment_methods}/edit', 'module' => 'payment_methods', 'as' => 'payment_methods.edit', 'icon' => null, 'parent' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePaymentMethods =  Permission::create(['name'  => 'delete_payment_methods', 'display_name'        =>  ['ar'   =>  'حذف بوابة الدفع',   'en'    =>  'Delete Payment Gateway'], 'route' => 'payment_methods/{payment_methods}', 'module' => 'payment_methods', 'as' => 'payment_methods.destroy', 'icon' => null, 'parent' => $managePaymentMethods->id, 'parent_original' => $managePaymentMethods->id, 'parent_show' => $managePaymentMethods->id, 'sidebar_link' => '0', 'appear' => '0']);


        //payment methodOffline
        $managePaymentMethodOfflines = Permission::create(['name' => 'manage_payment_method_offlines', 'display_name' => ['ar'  =>  'طرق الدفع',    'en'    =>  'Payment Methods'], 'route' => 'payment_method_offlines', 'module' => 'payment_method_offlines', 'as' => 'payment_method_offlines.index', 'icon' => 'fa fa-list-ul', 'parent' => $managePaymentCategories->id, 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '150',]);
        $managePaymentMethodOfflines->parent_show = $managePaymentMethodOfflines->id;
        $managePaymentMethodOfflines->save();
        $showPaymentMethodOfflines    =  Permission::create(['name' => 'show_payment_method_offlines',  'display_name'      =>  ['ar'   =>  'طرق الدفع',   'en'    =>  'Payment Methods Online'], 'route' => 'payment_method_offlines', 'module' => 'payment_method_offlines', 'as' => 'payment_method_offlines.index', 'icon' => 'fa fa-list-ul', 'parent' => $managePaymentMethodOfflines->id, 'parent_original' => $managePaymentMethodOfflines->id, 'parent_show' => $managePaymentMethodOfflines->id, 'sidebar_link' => '1', 'appear' => '1']);
        $createPaymentMethodOfflines  =  Permission::create(['name' => 'create_payment_method_offlines', 'display_name'     =>  ['ar'   =>  'إضافة طريقة دفع ',   'en'    =>  'Create Payment Method'], 'route' => 'payment_method_offlines', 'module' => 'payment_method_offlines', 'as' => 'payment_method_offlines.create', 'icon' => null, 'parent' => $managePaymentMethodOfflines->id, 'parent_original' => $managePaymentMethodOfflines->id, 'parent_show' => $managePaymentMethodOfflines->id, 'sidebar_link' => '0', 'appear' => '0']);
        $displayPaymentMethodOfflines =  Permission::create(['name' => 'display_payment_method_offlines', 'display_name'    =>  ['ar'   =>  'عرض طريقة دفع',   'en'    =>  'Display Payment Method'], 'route' => 'payment_method_offlines', 'module' => 'payment_method_offlines', 'as' => 'payment_method_offlines.show', 'icon' => null, 'parent' => $managePaymentMethodOfflines->id, 'parent_original' => $managePaymentMethodOfflines->id, 'parent_show' => $managePaymentMethodOfflines->id, 'sidebar_link' => '0', 'appear' => '0']);
        $updatePaymentMethodOfflines  =  Permission::create(['name' => 'update_payment_method_offlines', 'display_name'     =>  ['ar'   =>  'تعديل طريقة الدفع',   'en'    =>  'Edit Payment Method'], 'route' => 'payment_method_offlines', 'module' => 'payment_method_offlines', 'as' => 'payment_method_offlines.edit', 'icon' => null, 'parent' => $managePaymentMethodOfflines->id, 'parent_original' => $managePaymentMethodOfflines->id, 'parent_show' => $managePaymentMethodOfflines->id, 'sidebar_link' => '0', 'appear' => '0']);
        $deletePaymentMethodOfflines  =  Permission::create(['name' => 'delete_payment_method_offlines', 'display_name'     =>  ['ar'   =>  'حذف طريقة الدفع',   'en'    =>  'Delete Payment Method'], 'route' => 'payment_method_offlines', 'module' => 'payment_method_offlines', 'as' => 'payment_method_offlines.destroy', 'icon' => null, 'parent' => $managePaymentMethodOfflines->id, 'parent_original' => $managePaymentMethodOfflines->id, 'parent_show' => $managePaymentMethodOfflines->id, 'sidebar_link' => '0', 'appear' => '0']);
    }
}
