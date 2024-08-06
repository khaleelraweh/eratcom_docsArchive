<?php

namespace Database\Seeders;

use App\Models\Permission;


//manage Document Templates
$manageDocumentDatas = Permission::create(['name' => 'manage_document_datas', 'display_name' => ['ar'    =>  ' إدارة بيانات الوثيقة',   'en'    =>  '’Manage Document Datas'], 'route' => 'document_datas', 'module' => 'document_datas', 'as' => 'document_datas.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'sidebar_link' => '1', 'appear' => '1', 'ordering' => '15',]);
$manageDocumentDatas->parent_show = $manageDocumentDatas->id;
$manageDocumentDatas->save();
$showDocumentDatas    =  Permission::create(['name' => 'show_document_datas', 'display_name'       =>    ['ar'   =>  'بيانات الوثيقة',   'en'    =>  ' Document Datas'],   'route' => 'document_datas', 'module' => 'document_datas', 'as' => 'document_datas.index', 'icon' => 'fas fa-file-signature', 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$createDocumentDatas  =  Permission::create(['name' => 'create_document_datas', 'display_name'     =>    ['ar'   =>  'إضافة بيانات الوثيقة',   'en'    =>  'Add Document data'],    'route' => 'document_datas', 'module' => 'document_datas', 'as' => 'document_datas.create', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$displayDocumentDatas =  Permission::create(['name' => 'display_document_datas', 'display_name'    =>    ['ar'   =>  ' عرض بيانات الوثيقة',   'en'    =>  'Display Document data'],    'route' => 'document_datas', 'module' => 'document_datas', 'as' => 'document_datas.show', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$updateDocumentDatas  =  Permission::create(['name' => 'update_document_datas', 'display_name'     =>    ['ar'   =>  'تعديل بيانات الوثيقة',   'en'    =>  'Edit Document data'],    'route' => 'document_datas', 'module' => 'document_datas', 'as' => 'document_datas.edit', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
$deleteDocumentDatas  =  Permission::create(['name' => 'delete_document_datas', 'display_name'     =>    ['ar'   =>  'حذف بيانات الوثيقة',   'en'    =>  'Delete Document data'],    'route' => 'document_datas', 'module' => 'document_datas', 'as' => 'document_datas.destroy', 'icon' => null, 'parent' => '0', 'parent_original' => '0', 'parent_show' => '0', 'sidebar_link' => '0', 'appear' => '0']);
