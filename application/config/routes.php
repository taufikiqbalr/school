<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';
$route['home'] = "welcome";
// User session
$route['login'] = 'user_sessions/login';
$route['logout'] = 'user_sessions/logout';

// Kelas
$route['kelas/(:num)'] = 'guru/kelas/show/$1';
$route['kelas'] = 'guru/kelas/index';
$route['kelas/new'] = 'guru/kelas/new_k';
$route['kelas/(:num)/edit'] = 'guru/kelas/edit/$1';
$route['kelas/create'] = 'guru/kelas/create';
$route['kelas/(:num)/update'] = 'guru/kelas/update/$1';
$route['kelas/(:num)/delete'] = 'guru/kelas/delete/$1';
$route['kelas/deletes'] = 'guru/kelas/deletes';

// User
$route['users/(:num)'] = 'admin/users/show/$1';
$route['users'] = 'admin/users/index';
$route['users/new'] = 'admin/users/new_k';
$route['users/(:num)/edit'] = 'admin/users/edit/$1';
$route['users/create'] = 'admin/users/create';
$route['users/(:num)/update'] = 'admin/users/update/$1';
$route['users/(:num)/editpassword'] = 'admin/users/edit_password/$1';
$route['users/(:num)/changepassword'] = 'admin/users/update_password/$1';
$route['users/(:num)/delete'] = 'admin/users/delete/$1';
$route['users/deletes'] = 'admin/users/deletes';

// User Privilege
$route['userprivileges/(:num)'] = 'admin/user_privileges/show/$1';
$route['userprivileges'] = 'admin/user_privileges/index';
$route['userprivileges/new'] = 'admin/user_privileges/new_k';
$route['userprivileges/(:num)/edit'] = 'admin/user_privileges/edit/$1';
$route['userprivileges/create'] = 'admin/user_privileges/create';
$route['userprivileges/(:num)/update'] = 'admin/user_privileges/update/$1';
$route['userprivileges/(:num)/delete'] = 'admin/user_privileges/delete/$1';
$route['userprivileges/deletes'] = 'admin/user_privileges/deletes';

// User Group
$route['usergroups/(:num)'] = 'admin/user_groups/show/$1';
$route['usergroups'] = 'admin/user_groups/index';
$route['usergroups/new'] = 'admin/user_groups/new_k';
$route['usergroups/(:num)/edit'] = 'admin/user_groups/edit/$1';
$route['usergroups/create'] = 'admin/user_groups/create';
$route['usergroups/(:num)/update'] = 'admin/user_groups/update/$1';
$route['usergroups/(:num)/delete'] = 'admin/user_groups/delete/$1';
$route['usergroups/deletes'] = 'admin/user_groups/deletes';

// Privilege
$route['privileges/(:num)'] = 'admin/privileges/show/$1';
$route['privileges'] = 'admin/privileges/index';
$route['privileges/new'] = 'admin/privileges/new_k';
$route['privileges/(:num)/edit'] = 'admin/privileges/edit/$1';
$route['privileges/create'] = 'admin/privileges/create';
$route['privileges/(:num)/update'] = 'admin/privileges/update/$1';
$route['privileges/(:num)/delete'] = 'admin/privileges/delete/$1';
$route['privileges/deletes'] = 'admin/privileges/deletes';

// Group Privilege
$route['groupprivileges/(:num)'] = 'admin/group_privileges/show/$1';
$route['groupprivileges'] = 'admin/group_privileges/index';
$route['groupprivileges/new'] = 'admin/group_privileges/new_k';
$route['groupprivileges/(:num)/edit'] = 'admin/group_privileges/edit/$1';
$route['groupprivileges/create'] = 'admin/group_privileges/create';
$route['groupprivileges/(:num)/update'] = 'admin/group_privileges/update/$1';
$route['groupprivileges/(:num)/delete'] = 'admin/group_privileges/delete/$1';
$route['groupprivileges/deletes'] = 'admin/group_privileges/deletes';

// User Privilege
$route['userprivileges/(:num)'] = 'admin/user_privileges/show/$1';
$route['userprivileges'] = 'admin/user_privileges/index';
$route['userprivileges/new'] = 'admin/user_privileges/new_k';
$route['userprivileges/(:num)/edit'] = 'admin/user_privileges/edit/$1';
$route['userprivileges/create'] = 'admin/user_privileges/create';
$route['userprivileges/(:num)/update'] = 'admin/user_privileges/update/$1';
$route['userprivileges/(:num)/delete'] = 'admin/user_privileges/delete/$1';
$route['userprivileges/deletes'] = 'admin/user_privileges/deletes';

// Kelas Bagian
$route['kelasbagians/new/(:num)'] = 'guru/kelas_bagians/new_k/$1';
$route['kelasbagians/create/(:num)'] = 'guru/kelas_bagians/create/$1';
$route['kelasbagians/(:num)/edit'] = 'guru/kelas_bagians/edit/$1';
$route['kelasbagians/(:num)/update'] = 'guru/kelas_bagians/update/$1';
$route['kelasbagians/(:num)/delete'] = 'guru/kelas_bagians/delete/$1';
$route['kelasbagians/deletes/(:num)'] = 'guru/kelas_bagians/deletes/$1';

// Guru
$route['gurus/(:num)'] = 'guru/gurus/show/$1';
$route['gurus'] = 'guru/gurus/index';
$route['gurus/new'] = 'guru/gurus/new_k';
$route['gurus/(:num)/edit'] = 'guru/gurus/edit/$1';
$route['gurus/create'] = 'guru/gurus/create';
$route['gurus/(:num)/update'] = 'guru/gurus/update/$1';
$route['gurus/(:num)/delete'] = 'guru/gurus/delete/$1';
$route['gurus/deletes'] = 'guru/gurus/deletes';
$route['gurus/upload'] = 'guru/gurus/upload';

// Staff
$route['staffs/(:num)'] = 'admin/staffs/show/$1';
$route['staffs'] = 'admin/staffs/index';
$route['staffs/new'] = 'admin/staffs/new_k';
$route['staffs/(:num)/edit'] = 'admin/staffs/edit/$1';
$route['staffs/create'] = 'admin/staffs/create';
$route['staffs/(:num)/update'] = 'admin/staffs/update/$1';
$route['staffs/(:num)/delete'] = 'admin/staffs/delete/$1';
$route['staffs/deletes'] = 'admin/staffs/deletes';
$route['staffs/upload'] = 'admin/staffs/upload';

// Siswa
$route['siswas/(:num)'] = 'guru/siswas/show/$1';
$route['siswas'] = 'guru/siswas/index';
$route['siswas/new'] = 'guru/siswas/new_k';
$route['siswas/(:num)/edit'] = 'guru/siswas/edit/$1';
$route['siswas/create'] = 'guru/siswas/create';
$route['siswas/(:num)/update'] = 'guru/siswas/update/$1';
$route['siswas/(:num)/delete'] = 'guru/siswas/delete/$1';
$route['siswas/deletes'] = 'guru/siswas/deletes';
$route['siswas/upload'] = 'guru/siswas/upload';

// Kurikulum
$route['kurikulums/(:num)'] = 'admin/kurikulums/show/$1';
$route['kurikulums'] = 'admin/kurikulums/index';
$route['kurikulums/new'] = 'admin/kurikulums/new_k';
$route['kurikulums/(:num)/edit'] = 'admin/kurikulums/edit/$1';
$route['kurikulums/create'] = 'admin/kurikulums/create';
$route['kurikulums/(:num)/update'] = 'admin/kurikulums/update/$1';
$route['kurikulums/(:num)/delete'] = 'admin/kurikulums/delete/$1';
$route['kurikulums/deletes'] = 'admin/kurikulums/deletes';

// Tahun Ajaran
$route['tahunajarans/(:num)'] = 'admin/tahun_ajarans/show/$1';
$route['tahunajarans'] = 'admin/tahun_ajarans/index';
$route['tahunajarans/new'] = 'admin/tahun_ajarans/new_k';
$route['tahunajarans/(:num)/edit'] = 'admin/tahun_ajarans/edit/$1';
$route['tahunajarans/create'] = 'admin/tahun_ajarans/create';
$route['tahunajarans/(:num)/update'] = 'admin/tahun_ajarans/update/$1';
$route['tahunajarans/(:num)/delete'] = 'admin/tahun_ajarans/delete/$1';
$route['tahunajarans/deletes'] = 'admin/tahun_ajarans/deletes';

// Mata Pelajaran
$route['matapelajarans/(:num)'] = 'admin/mata_pelajarans/show/$1';
$route['matapelajarans'] = 'admin/mata_pelajarans/index';
$route['matapelajarans/new'] = 'admin/mata_pelajarans/new_k';
$route['matapelajarans/(:num)/edit'] = 'admin/mata_pelajarans/edit/$1';
$route['matapelajarans/create'] = 'admin/mata_pelajarans/create';
$route['matapelajarans/(:num)/update'] = 'admin/mata_pelajarans/update/$1';
$route['matapelajarans/(:num)/delete'] = 'admin/mata_pelajarans/delete/$1';
$route['matapelajarans/deletes'] = 'admin/mata_pelajarans/deletes';

// Absensi
$route['absensis/(:num)'] = 'guru/absensis/show/$1';
$route['absensis'] = 'guru/absensis/index';
$route['absensis/new'] = 'guru/absensis/new_k';
$route['absensis/(:num)/edit'] = 'guru/absensis/edit/$1';
$route['absensis/create'] = 'guru/absensis/create';
$route['absensis/(:num)/update'] = 'guru/absensis/update/$1';
$route['absensis/(:num)/delete'] = 'guru/absensis/delete/$1';
$route['absensis/deletes'] = 'guru/absensis/deletes';
$route['absensis/upload'] = 'guru/absensis/upload';
$route['absensis/download'] = 'guru/absensis/download';

// Jurusan
$route['jurusans/(:num)'] = 'admin/jurusans/show/$1';
$route['jurusans'] = 'admin/jurusans/index';
$route['jurusans/new'] = 'admin/jurusans/new_k';
$route['jurusans/(:num)/edit'] = 'admin/jurusans/edit/$1';
$route['jurusans/create'] = 'admin/jurusans/create';
$route['jurusans/(:num)/update'] = 'admin/jurusans/update/$1';
$route['jurusans/(:num)/delete'] = 'admin/jurusans/delete/$1';
$route['jurusans/deletes'] = 'admin/jurusans/deletes';

// Staff Ijazah
$route['staffijazahs/new/(:num)'] = 'admin/staff_ijazahs/new_k/$1';
$route['staffijazahs/create/(:num)'] = 'admin/staff_ijazahs/create/$1';
$route['staffijazahs/(:num)/edit'] = 'admin/staff_ijazahs/edit/$1';
$route['staffijazahs/(:num)/update'] = 'admin/staff_ijazahs/update/$1';
$route['staffijazahs/delete/(:num)'] = 'admin/staff_ijazahs/delete/$1';
$route['staffijazahs/deletes/(:num)'] = 'admin/staff_ijazahs/deletes/$1';

// Guru Ijazah
$route['guruijazahs/new/(:num)'] = 'guru/guru_ijazahs/new_k/$1';
$route['guruijazahs/create/(:num)'] = 'guru/guru_ijazahs/create/$1';
$route['guruijazahs/(:num)/edit'] = 'guru/guru_ijazahs/edit/$1';
$route['guruijazahs/(:num)/update'] = 'guru/guru_ijazahs/update/$1';
$route['guruijazahs/(:num)/delete'] = 'guru/guru_ijazahs/delete/$1';
$route['guruijazahs/(:num)/deletes'] = 'guru/guru_ijazahs/deletes/$1';

// Guru Wali
$route['guruwalis/new/(:num)'] = 'guru/guru_walis/new_k/$1';
$route['guruwalis/create/(:num)'] = 'guru/guru_walis/create/$1';
$route['guruwalis/(:num)/edit'] = 'guru/guru_walis/edit/$1';
$route['guruwalis/(:num)/update'] = 'guru/guru_walis/update/$1';
$route['guruwalis/(:num)/delete'] = 'guru/guru_walis/delete/$1';
$route['guruwalis/(:num)/deletes'] = 'guru/guru_walis/deletes/$1';

// Guru Mata Pelajaran
$route['gurumatapelajarans/new/(:num)'] = 'guru/guru_mata_pelajarans/new_k/$1';
$route['gurumatapelajarans/create/(:num)'] = 'guru/guru_mata_pelajarans/create/$1';
$route['gurumatapelajarans/(:num)/edit'] = 'guru/guru_mata_pelajarans/edit/$1';
$route['gurumatapelajarans/(:num)/update'] = 'guru/guru_mata_pelajarans/update/$1';
$route['gurumatapelajarans/(:num)/delete'] = 'guru/guru_mata_pelajarans/delete/$1';
$route['gurumatapelajarans/(:num)/deletes'] = 'guru/guru_mata_pelajarans/deletes/$1';

// Guru Kelas Matpel
$route['gurukelasmatpels/new/(:num)'] = 'guru/guru_kelas_matpels/new_k/$1';
$route['gurukelasmatpels/create/(:num)'] = 'guru/guru_kelas_matpels/create/$1';
$route['gurukelasmatpels/(:num)/edit'] = 'guru/guru_kelas_matpels/edit/$1';
$route['gurukelasmatpels/(:num)/update'] = 'guru/guru_kelas_matpels/update/$1';
$route['gurukelasmatpels/(:num)/delete'] = 'guru/guru_kelas_matpels/delete/$1';
$route['gurukelasmatpels/(:num)/deletes'] = 'guru/guru_kelas_matpels/deletes/$1';

// Siswa Kelas
$route['siswakelas/new/(:num)'] = 'admin/siswa_kelas/new_k/$1';
$route['siswakelas/create/(:num)'] = 'admin/siswa_kelas/create/$1';
$route['siswakelas/(:num)/edit'] = 'admin/siswa_kelas/edit/$1';
$route['siswakelas/(:num)/update'] = 'admin/siswa_kelas/update/$1';
$route['siswakelas/delete/(:num)'] = 'admin/siswa_kelas/delete/$1';
$route['siswakelas/deletes/(:num)'] = 'admin/siswa_kelas/deletes/$1';

// Siswa Nilai
$route['siswanilais/(:num)'] = 'admin/siswa_nilais/show/$1';
$route['siswanilais'] = 'admin/siswa_nilais/index';
$route['siswanilais/new'] = 'admin/siswa_nilais/new_k';
$route['siswanilais/(:num)/edit'] = 'admin/siswa_nilais/edit/$1';
$route['siswanilais/create'] = 'admin/siswa_nilais/create';
$route['siswanilais/(:num)/update'] = 'admin/siswa_nilais/update/$1';
$route['siswanilais/(:num)/delete'] = 'admin/siswa_nilais/delete/$1';
$route['siswanilais/deletes'] = 'admin/siswa_nilais/deletes';

// Siswa Nilai
$route['siswanilaiakhirs/(:num)'] = 'admin/siswa_nilai_akhirs/show/$1';
$route['siswanilaiakhirs'] = 'admin/siswa_nilai_akhirs/index';
$route['siswanilaiakhirs/(:num)/edit'] = 'admin/siswa_nilai_akhirs/edit/$1';
$route['siswanilaiakhirs/(:num)/update'] = 'admin/siswa_nilai_akhirs/update/$1';

// SPP
$route['spps/(:num)'] = 'staff/spps/show/$1';
$route['spps'] = 'staff/spps/index';
$route['spps/new'] = 'staff/spps/new_k';
$route['spps/(:num)/edit'] = 'staff/spps/edit/$1';
$route['spps/create'] = 'staff/spps/create';
$route['spps/(:num)/update'] = 'staff/spps/update/$1';
$route['spps/(:num)/delete'] = 'staff/spps/delete/$1';
$route['spps/deletes'] = 'staff/spps/deletes';

// Persentase Nilai
$route['matapelajaranpersentases/(:num)'] = 'guru/mata_pelajaran_persentases/show/$1';
$route['matapelajaranpersentases'] = 'guru/mata_pelajaran_persentases/index';
$route['matapelajaranpersentases/(:num)/edit'] = 'guru/mata_pelajaran_persentases/edit/$1';
$route['matapelajaranpersentases/(:num)/update'] = 'guru/mata_pelajaran_persentases/update/$1';

// API
$route['api/gurus/(:num)'] = 'api/gurus/show/$1';
$route['api/gurus'] = 'api/gurus/index';
$route['api/siswas/(:num)'] = 'api/siswas/show/$1';
$route['api/siswas'] = 'api/siswas/index';

/* End of file routes.php */
/* Location: ./application/config/routes.php */