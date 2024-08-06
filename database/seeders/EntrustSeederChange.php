<?php

namespace Database\Seeders;

use App\Models\Permission;


//manage Document Templates
$manageDocuments = Permission::create(['name' => 'manage_documents', 'display_name' => ['ar'    =>  ' إدارة الوثائق',   'en'    =>  '’Manage Documents'], 'route' => 'documents', 'module' => 'documents', 'as' => 'documents.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '15',]);
$manageDocuments->parent_show = $manageDocuments->id;
$manageDocuments->save();
$showDocuments    =  Permission::create(['name' => 'show_documents', 'display_name'       =>    ['ar'   =>  ' الوثائق',   'en'    =>  ' Documents'],   'route' => 'documents', 'module' => 'documents', 'as' => 'documents.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$createDocuments  =  Permission::create(['name' => 'create_documents', 'display_name'     =>    ['ar'   =>  'إضافة وثيقة',   'en'    =>  'Add Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$displayDocuments =  Permission::create(['name' => 'display_documents', 'display_name'    =>    ['ar'   =>  ' عرض وثيقة',   'en'    =>  'Display Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$updateDocuments  =  Permission::create(['name' => 'update_documents', 'display_name'     =>    ['ar'   =>  'تعديل وثيقة',   'en'    =>  'Edit Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$deleteDocuments  =  Permission::create(['name' => 'delete_documents', 'display_name'     =>    ['ar'   =>  'حذف وثيقة',   'en'    =>  'Delete Document'],    'route' => 'documents', 'module' => 'documents', 'as' => 'documents.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
