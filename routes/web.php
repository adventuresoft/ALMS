<?php

use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AddressInfoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ApprovalFarmerController;
use App\Http\Controllers\BankBranchController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\BankSellingController;
use App\Http\Controllers\BasicSettings\CityCorporationWardController;
use App\Http\Controllers\BasicSettings\CityCorporationController;
use App\Http\Controllers\BasicSettings\FamilyCategoryController;
use App\Http\Controllers\BasicSettings\FamilySubCategoryController;
use App\Http\Controllers\BasicSettings\FamilyTypeController;
use App\Http\Controllers\BasicSettings\HouseOwnerTypeController;
use App\Http\Controllers\BasicSettings\HouseCategoryController;
use App\Http\Controllers\BasicSettings\HouseTypeController;
use App\Http\Controllers\BasicSettings\LandClassController;
use App\Http\Controllers\BasicSettings\LandOwnershipTypeController;
use App\Http\Controllers\BasicSettings\LandTypeController;
use App\Http\Controllers\BasicSettings\MarketCategoryController;
use App\Http\Controllers\BasicSettings\MarketOwnershipTypeController;
use App\Http\Controllers\BasicSettings\MarketTypeController;
use App\Http\Controllers\BasicSettings\OrganizationCategoryController;
use App\Http\Controllers\BasicSettings\OrganizationClassController;
use App\Http\Controllers\BasicSettings\OrganizationOwnershipTypeController;
use App\Http\Controllers\BasicSettings\OrganizationSubCategoryController;
use App\Http\Controllers\BasicSettings\OrganizationWorkAreaController;
use App\Http\Controllers\BasicSettings\OrganizationTypeController;
use App\Http\Controllers\BasicSettings\ProfessionCategoryController;
use App\Http\Controllers\BasicSettings\ProfessionController;
use App\Http\Controllers\BasicSettings\FinancialYearController;
use App\Http\Controllers\BasicSettings\ProfessionSubCategoryController;
use App\Http\Controllers\BasicSettings\ProfessionTypeController;
use App\Http\Controllers\BasicSettings\ReserveWardController;
use App\Http\Controllers\BasicSettings\RoadCategoryController;
use App\Http\Controllers\BasicSettings\RoadOwnerController;
use App\Http\Controllers\BasicSettings\RoadTypeController;
use App\Http\Controllers\BasicSettings\UnionWardController;
use App\Http\Controllers\BasicSettings\VehicleCategoryController;
use App\Http\Controllers\BasicSettings\VehicleSubCategoryController;
use App\Http\Controllers\BasicSettings\VehicleTypeController;
use App\Http\Controllers\BasicSettings\VillageController;
use App\Http\Controllers\BasicSettings\VillageAreaController;
use App\Http\Controllers\BasicSettings\UnionController as BasicUnionController;
use App\Http\Controllers\BridgeController;
use App\Http\Controllers\Certificate\BirthCertificateController;
use App\Http\Controllers\Certificate\CharacterCertificateController;
use App\Http\Controllers\Certificate\CitizenCertificateController;
use App\Http\Controllers\Certificate\DeathCertificateController;
use App\Http\Controllers\Certificate\UnmarriedCertificateController;
use App\Http\Controllers\Certificate\MarriedCertificateController;
use App\Http\Controllers\Certificate\RemarriedCertificateController;
use App\Http\Controllers\Certificate\LandlessCertificateController;
use App\Http\Controllers\Certificate\NameCertificateController;
use App\Http\Controllers\Certificate\YearlyIncomeCertificateController;
use App\Http\Controllers\Certificate\DisabilityCertificateController;

use App\Http\Controllers\Certificate\GuardianCertificateController;
use App\Http\Controllers\Certificate\ResidentialCertificateController;
use App\Http\Controllers\Certificate\PermanentCitizenCertificateController;
use App\Http\Controllers\Certificate\AgeCertificateController;
use App\Http\Controllers\Certificate\FinancialInstabilityCertificateController;

use App\Http\Controllers\Certificate\OrphanCertificateController;
use App\Http\Controllers\Certificate\ChildlessCertificateController;
use App\Http\Controllers\Certificate\NidCorrectionCertificateController;
use App\Http\Controllers\Certificate\VoterListCertificateController;
use App\Http\Controllers\Certificate\VoterAreaCertificateController;


use App\Http\Controllers\ClassificationInfoController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\RoleUserController;
use App\Http\Controllers\BankUserController;
use App\Http\Controllers\SubsidyController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCredentialController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisabilityInfoController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\DivorceController;
use App\Http\Controllers\EducationalInfoController;
use App\Http\Controllers\FamilyInfoController;
use App\Http\Controllers\FinancialInfoController;
use App\Http\Controllers\FreedomFighterInfoController;
use App\Http\Controllers\HealthInfoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\HouseOwnershipController;
use App\Http\Controllers\InstituteCategoryController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\InstitutionalAdminController;
use App\Http\Controllers\InstituteTypeController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\MarriageController;
use App\Http\Controllers\MouzaController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Organization\OrganizationBranchController;
use App\Http\Controllers\Organization\TradeLicenseController;
use App\Http\Controllers\Organization\OrganizationFeeController;
use App\Http\Controllers\Organization\OrganizationOwnershipController;
use App\Http\Controllers\Organization\OrganizationRenewController;

use App\Http\Controllers\OrganizationPeopleController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\ProfessionalInfoController;
use App\Http\Controllers\ProjectTypeController;
use App\Http\Controllers\PropertyInfoController;
use App\Http\Controllers\RoadController;
use App\Http\Controllers\Tax\TaxController;
use App\Http\Controllers\Tax\TaxRateController;
use App\Http\Controllers\Tax\TaxYearController;
use App\Http\Controllers\ThanaController;
use App\Http\Controllers\UnionController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ChairmanController;
use App\Http\Controllers\CouncilorController;
use App\Http\Controllers\CultivationInfoController;
use App\Http\Controllers\LandInfoController;
use App\Http\Controllers\LoanInfoController;
use App\Http\Controllers\LoanPaymentController;
use App\Http\Controllers\LoanApplyController;
use App\Http\Controllers\BankAdminController;
use App\Http\Controllers\ReportController;
use Database\Seeders\LoanInfoSeeder;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sms', function(){
    return view('frontend.pages.sms');
});

Route::get('test-api', [HomeController::class, 'testHttpRequest']);

// Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login-check', [LoginController::class, 'loginCheck'])->name('login.check');

// Register
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register/store', [LoginController::class, 'registerStore'])->name('register.store');
Route::get('/profile', [LoginController::class, 'profile'])->name('profile')->middleware('auth');

// Application
Route::prefix('application')->name('application.')->group(function () {
    Route::get('/', [ApplicationController::class, 'create'])->name('create');
    Route::post('store', [ApplicationController::class, 'store'])->name('store');
    Route::get('success/{system_id}', [ApplicationController::class, 'success'])->name('success');
        Route::get('verify', [ApplicationController::class,'verify'])->name('verify');

});

Route::get('/branch-options/{bank_id}', [BankBranchController::class, 'options']);

/* permisison */
// Role route start
Route::controller(RoleController::class)->group(function () {
    Route::get('role','index')->name('role.index');
    Route::post('role','store')->name('role.store');
    Route::get('role/{id}/edit','edit')->name('role.edit');
    Route::patch('role/{id}','update')->name('role.update');
    Route::delete('role/{id}','destroy')->name('role.destroy');
});

Route::resource('module', App\Http\Controllers\ModuleController::class);

// Role Permission Matrix
Route::get('role/{id}/permissions', [RoleController::class, 'permissions'])->name('role.permissions');
Route::post('role/{id}/permissions', [RoleController::class, 'updatePermissions'])->name('role.permissions.update');


// Permission route start
Route::controller(PermissionController::class)->group(function () {
    Route::get('permission','index')->name('permission.index');
    Route::post('permission','store')->name('permission.store');
    Route::get('permission/{id}/edit','edit')->name('permission.edit');
    Route::patch('permission/{id}','update')->name('permission.update');
});

// Role Permission route start
Route::controller(RolePermissionController::class)->group(function () {
    Route::get('rolepermission','index')->name('rolepermission.index');
    Route::post('rolepermission','store')->name('rolepermission.store');
    Route::get('rolepermission/{role_id}/edit/{permission_id}','edit')->name('rolepermission.edit');
    Route::patch('rolepermission/{id}','update')->name('rolepermission.update');
    Route::post('rolepermission/destroy','destroy')->name('rolepermission.destroy');
});

// Role User route start
Route::controller(RoleUserController::class)->group(function () {
    Route::get('roleuser','index')->name('roleuser.index');
    Route::get('roleuser/create','create')->name('roleuser.create');
    Route::post('roleuser','store')->name('roleuser.store');
    Route::get('roleuser/{role_id}/edit/{user_id}','edit')->name('roleuser.edit');
    Route::patch('roleuser/{id}','update')->name('roleuser.update');
    Route::post('roleuser/roleusersoft','roleusersoft')->name('roleuser.roleusersoft');

});



// BankUser Routes
Route::prefix('bankuser')
    ->name('bankuser.')
    ->controller(BankUserController::class)
    ->group(function () {

        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{bank_id}/edit/{user_id}', 'edit')->name('edit');
        Route::patch('/{id}', 'update')->name('update');
        Route::post('/soft', 'roleusersoft')->name('soft');

        // Autocomplete
        
    });

Route::get('/autocomplete/users', [BankUserController::class,'autocompleteUsers'])->name('autocomplete.users');
Route::get('/autocomplete/banks', [BankUserController::class,'autocompleteBanks'])->name('autocomplete.banks');



// User Permission route start
Route::controller(UserPermissionController::class)->group(function () {
    Route::get('userper','index')->name('userper.index');
    Route::get('userper/create','create')->name('userper.create');
    Route::post('userper','store')->name('userper.store');
    Route::get('userper/{model_id}/edit/{permission_id}','edit')->name('userper.edit');
    Route::patch('userper/{id}','update')->name('userper.update');
    Route::post('userper/delete','destroy')->name('userper.destroy');
});


Route::get('/autocomplete/users', [RoleUserController::class, 'autocompleteUsers'])
    ->name('autocomplete.users');
Route::get('/autocomplete/roles', [RoleUserController::class, 'autocompleteRoles'])
    ->name('autocomplete.roles');

    Route::middleware(['auth'])->group(function () {

    // Show reset form
    Route::get('/user/{user}/credentials', [UserCredentialController::class, 'edit'])
        ->name('user.credentials.edit');

    // Handle form submit
    Route::post('/user/{user}/credentials', [UserCredentialController::class, 'update'])
        ->name('user.credentials.update');
});    
    
Route::post('/user/assign-role', [UserController::class, 'assignRole'])->name('user.assignRole');
Route::resource('user',UserController::class);
Route::resource('bank-admin', BankAdminController::class);
 
Route::resource('people', PeopleController::class);

Route::get('/people/family/{userID}', [PeopleController::class, 'family'])->name('people.family');
Route::post('/people/family-store', [PeopleController::class, 'familyStore'])->name('people.familyStore');

 Route::get('people/address/{userID}', [PeopleController::class, 'address'])->name('people.address');
 Route::post('people/address-store', [PeopleController::class, 'addressStore'])->name('people.addressStore');


  Route::get('people/professional/{userID}', [PeopleController::class, 'professional'])->name('people.professional');
 Route::post('people/professional-store', [PeopleController::class, 'professionalStore'])->name('people.professionalStore');

 Route::get('people/health/{userID}', [PeopleController::class, 'health'])->name('people.health');
 Route::post('people/health-store', [PeopleController::class, 'healthStore'])->name('people.healthStore');

 Route::get('people/disability/{userID}', [PeopleController::class, 'disability'])->name('people.disability');
 Route::post('people/disability-store', [PeopleController::class, 'disabilityStore'])->name('people.disabilityStore');

 Route::get('people/freedom/{userID}', [PeopleController::class, 'freedom'])->name('people.freedom');
 Route::post('people/freedom-store', [PeopleController::class, 'freedomStore'])->name('people.freedomStore');

 Route::get('people/education/{userID}', [PeopleController::class, 'education'])->name('people.education');
 Route::post('people/education-store', [PeopleController::class, 'educationStore'])->name('people.educationStore');
 Route::get('people/education-delete/{eduID}', [PeopleController::class, 'educationDelete'])->name('people.educationDelete');

 Route::get('people/cultivation/add-new', [PeopleController::class, 'cultivationAddNew'])->name('people.cultivation.add-new');
 Route::get('people/cultivation/{userID}', [PeopleController::class, 'cultivation'])->name('people.cultivation');
 Route::post('people/cultivation-store', [PeopleController::class, 'cultivationStore'])->name('people.cultivationStore');
 Route::get('people/cultivation-delete/{proID}', [PeopleController::class, 'cultivationDelete'])->name('people.cultivationDelete');

 Route::get('people/classification/add-new', [PeopleController::class, 'classificationAddNew'])->name('people.classification.add-new');
 Route::get('people/classification/{userID}', [PeopleController::class, 'classification'])->name('people.classification');
 Route::post('people/classification-store', [PeopleController::class, 'classificationStore'])->name('people.classificationStore');
 Route::get('people/classification-delete/{proID}', [PeopleController::class, 'classificationDelete'])->name('people.classificationDelete');


 Route::get('people/financial/{userID}', [PeopleController::class, 'financial'])->name('people.financial');
 Route::post('people/financial-store', [PeopleController::class, 'financialStore'])->name('people.financialStore');
 Route::get('people/financial-delete/{proID}', [PeopleController::class, 'financialDelete'])->name('people.financialDelete');

 Route::get('people/property/{userID}', [PeopleController::class, 'property'])->name('people.property');
 Route::post('people/property-store', [PeopleController::class, 'propertyStore'])->name('people.propertyStore');
 Route::get('people/property-delete/{proID}', [PeopleController::class, 'propertyDelete'])->name('people.propertyDelete');
    
    
    
/* end permission */
Route::post('/load-project-type-content', [ProjectTypeController::class, 'projectTypeContent'])->name('projectTypeContent');
Route::post('/backend/load-project-type-content', [ProjectTypeController::class, 'backendProjectTypeContent'])->name('backendProjectTypeContent');

// Find Dependencies
Route::get('/get-districts-by-division/{divisionID}', [DistrictController::class, 'districtsByDivision']);
Route::get('/get-thanas-by-district/{districtID}', [ThanaController::class, 'thanasByDistrict']);
Route::get('/get-word-by-union/{unionID}', [UnionWardController::class, 'wordByUnion']);
Route::get('/get-citi-corporation-by-district/{districtID}', [CityCorporationController::class, 'cityCorporationByDistrict']);
Route::get('/get-unions-by-thana/{thanaID}', [UnionController::class, 'unionsByThana']);
Route::get('/get-villages-by-union/{unionID}', [VillageController::class, 'villagesByUnion']);
Route::get('/get-mouzas-by-thana/{thanaID}', [MouzaController::class, 'mouzasByThana']);
Route::get('/get-areas-by-village/{villageID}', [VillageAreaController::class, 'areasByVillage']);
Route::get('/get-houses-by-village-area/{areaID}', [HouseController::class, 'getHouseByArea']);
Route::get('/search-user-by-system-id/{systemID}', [PeopleController::class, 'searchUser'])->name('user.searchBySystemID');
Route::get('search-user-and-loans-by-system-id/{systemID}', [PeopleController::class, 'searchLoanUser'])->name('user.loanInfo.searchBySystemID');
Route::get('search-user-and-loans-payments-by-system-id/{systemID}', [PeopleController::class, 'searchPaymentUser'])->name('user.loanInfo.searchPaymentUser');

Route::get('/get-organization-info-by-system-id/{systemID}', [OrganizationController::class, 'getOrganizationBySystemId'])->name('getOrganizationBySystemId');


Route::get('/profession-type-options-by-profession/{professionID}', [ProfessionTypeController::class, 'professionTypeOptions']);
Route::get('/profession-category-options-by-profession-type/{professionTypeID}', [ProfessionCategoryController::class, 'professionCategoryOptions' ]);
Route::get('/profession-subcategory-options-by-profession-category/{professionCategoryID}', [ ProfessionSubcategoryController::class, 'professionSubcategoryOptions'  ] );

Route::get('/house-category-options-by-type-id/{type_id}', [HouseCategoryController::class, 'getCategoryOptions']);
Route::get('/house-single-ownership-form', [HouseOwnershipController::class, 'loadOwnershipForm']);
Route::get('/house-ownership-remove/{id}', [HouseOwnershipController::class, 'destroy']);

Route::get('/organization-subcategory-options/{id}', [OrganizationSubCategoryController::class, 'options']);
Route::get('/house-options/{id}', [HouseController::class, 'options']);
Route::get('/organization-work-area-options/{id}', [OrganizationWorkAreaController::class, 'options']);
Route::get('/organization-type-options/{id}', [OrganizationTypeController::class, 'options']);

Route::get('/organization-single-ownership-form', [OrganizationOwnershipController::class, 'ownershipForm']);
Route::get('/organization-ownership-remove/{id}', [OrganizationOwnershipController::class, 'destroy']);

Route::post('/get-organization-registration-fees', [OrganizationFeeController::class, "registrationFees"])->name('organization.registration.fees');
// Admin with Auth
Route::get('get-people-by-union/{union_id}', [ChairmanController::class, 'getPeopleByUnion']);
Route::get('changeMember/{councilor_member_id}', [ChairmanController::class, 'changeMember'])->name('chairman.changeMember');
Route::post('/councilorUpdate', [ChairmanController::class, "councilorUpdate"])->name('chairman.councilorUpdate');

Route::get('/farmer/land/add-new', [LandInfoController::class, 'addNew'])->name('farmer.land.add-new');
Route::get('/farmer/cultivation/add-new', [CultivationInfoController::class, 'addNew'])->name('farmer.cultivation.add-new');

 
  
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

   
    Route::resource('farmer', FarmerController::class);
    
    Route::get('farmer-permission/{id}', [FarmerController::class, 'permission'])->name('farmer.permission');
    Route::resource('approved-farmer', ApprovalFarmerController::class);
    Route::resource('approval', ApprovalFarmerController::class);
    
     Route::post('/farmers/approve/{id}', [FarmerController::class, 'approve'])->name('farmers.approve');
    Route::post('/farmers/{id}/reject', [FarmerController::class, 'reject'])->name('farmers.reject');
    Route::get('/farmers/{id}/change-status', [FarmerController::class, 'changeStatus'])->name('farmers.changeStatus');
     Route::get('/farmers/{id}/change-status', [FarmerController::class, 'changeStatus'])->name('farmers.changeStatus');
    Route::get('view-all-farmers', [FarmerController::class, 'showAll'])->name('farmer-show-all');
    Route::get('/farmer/family/{userID}', [FamilyInfoController::class, 'create'])->name('farmer.family');
    Route::post('/farmer/family-store', [FamilyInfoController::class, 'store'])->name('farmer.familyStore');

    Route::get('/farmer/address/{userID}', [AddressInfoController::class, 'create'])->name('farmer.address');
    Route::post('/farmer/address-store', [AddressInfoController::class, 'store'])->name('farmer.addressStore');

    Route::get('/farmer/health/{userID}', [HealthInfoController::class, 'create'])->name('farmer.health');
    Route::post('/farmer/health-store', [HealthInfoController::class, 'store'])->name('farmer.healthStore');

    Route::get('/farmer/disability/{userID}', [DisabilityInfoController::class, 'create'])->name('farmer.disability');
    Route::post('/farmer/disability-store', [DisabilityInfoController::class, 'store'])->name('farmer.disabilityStore');

    Route::get('/farmer/freedom/{userID}', [FreedomFighterInfoController::class, 'create'])->name('farmer.freedom');
    Route::post('/farmer/freedom-store', [FreedomFighterInfoController::class, 'store'])->name('farmer.freedomStore');

    Route::get('/farmer/education/{userID}', [EducationalInfoController::class, 'create'])->name('farmer.education');
    Route::post('/farmer/education-store', [EducationalInfoController::class, 'store'])->name('farmer.educationStore');
    Route::get('/farmer/education-delete/{eduID}', [EducationalInfoController::class, 'destroy'])->name('farmer.educationDelete');

    // Route::get('/farmer/cultivation/add-new', [CultivationInfoController::class, 'addNew'])->name('farmer.cultivation.add-new');
    Route::get('/farmer/cultivation/{userID}', [CultivationInfoController::class, 'create'])->name('farmer.cultivation');
    Route::post('/farmer/cultivation-store', [CultivationInfoController::class, 'store'])->name('farmer.cultivationStore');
    Route::get('/farmer/cultivation-delete/{proID}', [CultivationInfoController::class, 'destroy'])->name('farmer.cultivationDelete');

    // Route::get('/farmer/land/add-new', [LandInfoController::class, 'addNew'])->name('farmer.land.add-new');
    Route::get('/farmer/land/{userID}', [LandInfoController::class, 'create'])->name('farmer.land');
    Route::post('/farmer/land-store', [LandInfoController::class, 'store'])->name('farmer.landStore');
    Route::get('/farmer/land-delete/{proID}', [LandInfoController::class, 'destroy'])->name('farmer.landDelete');


    Route::get('/farmer/classification/add-new', [ClassificationInfoController::class, 'addNew'])->name('farmer.classification.add-new');
    Route::get('/farmer/classification/{userID}', [ClassificationInfoController::class, 'create'])->name('farmer.classification');
    Route::post('/farmer/classification-store', [ClassificationInfoController::class, 'store'])->name('farmer.classificationStore');
    Route::get('/farmer/classification-delete/{proID}', [ClassificationInfoController::class, 'destroy'])->name('farmer.classificationDelete');


    Route::get('/farmer/financial/{userID}', [FinancialInfoController::class, 'create'])->name('farmer.financial');
    Route::post('/farmer/financial-store', [FinancialInfoController::class, 'store'])->name('farmer.financialStore');
    Route::get('/farmer/financial-delete/{proID}', [FinancialInfoController::class, 'destroy'])->name('farmer.financialDelete');

    Route::get('/farmer/property/{userID}', [PropertyInfoController::class, 'create'])->name('farmer.property');
    Route::post('/farmer/property-store', [PropertyInfoController::class, 'store'])->name('farmer.propertyStore');
    Route::get('/farmer/property-delete/{proID}', [PropertyInfoController::class, 'destroy'])->name('farmer.propertyDelete');

    Route::resource('certificate/citizen', CitizenCertificateController::class);
    Route::get('certificate/citizen/bn/{id}', [CitizenCertificateController::class, 'bn_certificate'])->name('citizen.bn_certificate');
    Route::resource('certificate/character', CharacterCertificateController::class);
    Route::get('certificate/character/bn/{id}', [CharacterCertificateController::class, 'bn_certificate'])->name('character.bn_certificate');
    Route::resource('certificate/death', DeathCertificateController::class);
    Route::resource('certificate/birth', BirthCertificateController::class);
    Route::resource('certificate/unmarried', UnmarriedCertificateController::class);
    Route::get('certificate/unmarried/bn/{id}', [UnmarriedCertificateController::class, 'bn_certificate'])->name('unmarried.bn_certificate');
    Route::resource('certificate/married', MarriedCertificateController::class);
    Route::get('certificate/married/bn/{id}', [MarriedCertificateController::class, 'bn_certificate'])->name('married.bn_certificate');
    Route::resource('certificate/remarried', RemarriedCertificateController::class);
    Route::get('certificate/remarried/bn/{id}', [RemarriedCertificateController::class, 'bn_certificate'])->name('remarried.bn_certificate');
    Route::resource('certificate/landless', LandlessCertificateController::class);
    Route::get('certificate/landless/bn/{id}', [LandlessCertificateController::class, 'bn_certificate'])->name('landless.bn_certificate');
    Route::resource('certificate/name', NameCertificateController::class);
    Route::get('certificate/name/bn/{id}', [NameCertificateController::class, 'bn_certificate'])->name('name.bn_certificate');
    Route::resource('certificate/income', YearlyIncomeCertificateController::class);
    Route::get('certificate/income/bn/{id}', [YearlyIncomeCertificateController::class, 'bn_certificate'])->name('income.bn_certificate');
    Route::resource('certificate/disability-certificate', DisabilityCertificateController::class);
    Route::get('certificate/disability/bn/{id}', [DisabilityCertificateController::class, 'bn_certificate'])->name('disability.bn_certificate');
    Route::resource('certificate/voter-area', VoterAreaCertificateController::class);
    Route::get('certificate/voter-area/bn/{id}', [VoterAreaCertificateController::class, 'bn_certificate'])->name('voter-area.bn_certificate');
    Route::resource('certificate/voter-list', VoterListCertificateController::class);
    Route::get('certificate/voter-list/bn/{id}', [VoterListCertificateController::class, 'bn_certificate'])->name('voter-list.bn_certificate');
    Route::resource('certificate/nid-correction', NidCorrectionCertificateController::class);
    Route::get('certificate/nid-correction/bn/{id}', [NidCorrectionCertificateController::class, 'bn_certificate'])->name('nid-correction.bn_certificate');
    Route::resource('certificate/childless', ChildlessCertificateController::class);
    Route::get('certificate/childless/bn/{id}', [ChildlessCertificateController::class, 'bn_certificate'])->name('childless.bn_certificate');

    Route::resource('certificate/orphan', OrphanCertificateController::class);
    Route::get('certificate/orphan/bn/{id}', [OrphanCertificateController::class, 'bn_certificate'])->name('orphan.bn_certificate');
    Route::resource('certificate/financial-instability', FinancialInstabilityCertificateController::class);
    Route::get('certificate/financial-instability/bn/{id}', [FinancialInstabilityCertificateController::class, 'bn_certificate'])->name('financial-instability.bn_certificate');
    Route::resource('certificate/age', AgeCertificateController::class);
    Route::get('certificate/age/bn/{id}', [AgeCertificateController::class, 'bn_certificate'])->name('age.bn_certificate');
    Route::resource('certificate/permanent-citizen', PermanentCitizenCertificateController::class);
    Route::get('certificate/permanent-citizen/bn/{id}', [PermanentCitizenCertificateController::class, 'bn_certificate'])->name('permanent-citizen.bn_certificate');
    Route::resource('certificate/residential', ResidentialCertificateController::class);
    Route::get('certificate/residential/bn/{id}', [ResidentialCertificateController::class, 'bn_certificate'])->name('residential.bn_certificate');
    Route::resource('certificate/guardian-income', GuardianCertificateController::class);
    Route::get('certificate/guardian-income/bn/{id}', [GuardianCertificateController::class, 'bn_certificate'])->name('guardian-income.bn_certificate');


    Route::prefix('basic-settings')->name('basic-settings.')->group(function () {
        Route::resource('village-area', VillageAreaController::class);
        Route::resource('village', VillageController::class);
        Route::resource('union', BasicUnionController::class);
        Route::resource('union-ward', UnionWardController::class);
        Route::resource('reserve-ward', ReserveWardController::class);
        Route::resource('city-corporation', CityCorporationController::class);
        Route::resource('city-corporation-ward', CityCorporationWardController::class);
        Route::resource('road-category', RoadCategoryController::class);
        Route::resource('road-type', RoadTypeController::class);
        Route::resource('road-owner', RoadOwnerController::class);

        Route::resource('profession', ProfessionController::class);
        Route::resource('financial-year', FinancialYearController::class);
        Route::resource('profession-category', ProfessionCategoryController::class);
        Route::resource('profession-subcategory', ProfessionSubCategoryController::class);
        Route::resource('profession-type', ProfessionTypeController::class);

        Route::resource('land-type', LandTypeController::class);
        Route::resource('land-class', LandClassController::class);
        Route::resource('land-ownership-type', LandOwnershipTypeController::class);

        Route::resource('house-ownership-type', HouseOwnerTypeController::class );
        Route::resource('house-type', HouseTypeController::class);
        Route::resource('house-category', HouseCategoryController::class);

        Route::resource('organization-ownership-type', OrganizationOwnershipTypeController::class);
        Route::resource('organization-category', OrganizationCategoryController::class);
        Route::resource('organization-subcategory', OrganizationSubCategoryController::class);
        Route::resource('organization-work-area', OrganizationWorkAreaController::class);

        Route::resource('organization-type', OrganizationTypeController::class);
      



        Route::resource('family-category', FamilyCategoryController::class);
        Route::resource('family-subcategory', FamilySubCategoryController::class);
        Route::resource('family-type', FamilyTypeController::class);

        Route::resource('vehicle-type', VehicleTypeController::class);
        Route::resource('vehicle-category', VehicleCategoryController::class);
        Route::resource('vehicle-subcategory', VehicleSubCategoryController::class);

        Route::resource('market-type', MarketTypeController::class);
        Route::resource('market-category', MarketCategoryController::class);
        Route::resource('market-ownership-type', MarketOwnershipTypeController::class);
    });

    Route::resource('organization', OrganizationController::class);
      Route::resource('organization-branch', OrganizationBranchController::class);
      Route::get('organization/getBranches/{branch_id}',[OrganizationBranchController::class,'getBranches'])->name('organization.getBranches');
        Route::resource('organization-people', OrganizationPeopleController::class);
        //Route::resource('organizationpeople', OrganizationPeopleController::class);
        
        Route::get('/autocomplete/organizations', [OrganizationPeopleController::class,'autocompleteOrganizations'])->name('autocomplete.organizations');
        Route::get('/autocomplete/people', [OrganizationPeopleController::class,'autocompleteUsers'])->name('autocomplete.people');
    Route::resource('chairman', ChairmanController::class);

    // Bank
    Route::resource('bank', BankController::class);
    Route::resource('bank-branch', BankBranchController::class);
    Route::resource('bank-selling', BankSellingController::class);
    Route::resource('loan-info', LoanInfoController::class);
    Route::resource('loan-payment', LoanPaymentController::class);
    
    Route::get('loan-apply',[LoanInfoController::class, 'apply'])->name('loan.apply');
    Route::post('/loan-apply/store', [LoanInfoController::class, 'applystore'])
    ->name('loan.apply.store');
    
    
    Route::post('/loan-apply/store', [LoanInfoController::class, 'applystore'])->name('loan.apply.store');
    // Loan Application List
    Route::get('/loan-apply/all', [LoanApplyController::class, 'allapply'])->name('loan.apply.all');
    
    // View single application
    Route::get('/loan-apply/view/{id}', [LoanApplyController::class, 'view'])->name('loan.apply.view');
    
    // Approve application → save to loan_infos
    Route::post('/loan-apply/approve/{id}', [LoanApplyController::class, 'approve'])->name('loan.apply.approve');
    
    // Reject application
    Route::post('/loan-apply/reject/{id}', [LoanApplyController::class, 'reject'])->name('loan.apply.reject');
    
    Route::get('/get-branches/{bank_id}', [LoanApplyController::class, 'getBranches'])
        ->name('loan.getBranches');
        
    Route::post('/loan/apply/proceed/{id}', [LoanApplyController::class, 'proceed'])->name('loan.apply.proceed');
    
    // Subsidies
    Route::resource('subsidy', SubsidyController::class);

    Route::post('/fromupdate', [ChairmanController::class,'fromupdate'])->name('chairman.fromupdate');

    Route::controller(ChairmanController::class)->prefix('chairman')->name('chairman.')->group(function () {
         Route::post('/personalstore', 'personalstore')->name('personalstore');
         Route::post('/autocomplete/fetch', 'fetch')->name('fetch');

         // Route::get('/family/{user_id}', 'family')->name('family');
         // Route::post('/familyStore', 'familyStore')->name('familyStore');
         // Route::get('/address/{user_id}', 'address')->name('address');
         // Route::post('/addressStore', 'addressStore')->name('addressStore');
         // Route::get('/education/{user_id}', 'education')->name('education');
         // Route::post('/educationStore', 'educationStore')->name('educationStore');

         // Route::get('/professional/{user_id}', 'professional')->name('professional');
         // Route::post('/professionalStore', 'professionalStore')->name('professionalStore');
         // Route::get('/financial/{user_id}', 'financial')->name('financial');
         // Route::post('/financialStore', 'financialStore')->name('financialStore');

         // Route::get('/property/{user_id}', 'property')->name('property');
         // Route::post('/propertyStore', 'propertyStore')->name('propertyStore');

         // Route::get('/disability/{user_id}', 'disability')->name('disability');
         // Route::post('/disabilityStore', 'disabilityStore')->name('disabilityStore');

         // Route::get('/freedom/{user_id}', 'freedom')->name('freedom');
         // Route::post('/freedomStore', 'freedomStore')->name('freedomStore');

         // Route::get('/area/{user_id}', 'area')->name('area');
         // Route::post('/areaStore', 'areaStore')->name('areaStore');
    });


    Route::resource('councilor', CouncilorController::class);
    Route::controller(CouncilorController::class)->prefix('councilor')->name('councilor.')->group(function () {
         Route::post('/personalstore', 'personalstore')->name('personalstore');
         Route::get('/family/{user_id}', 'family')->name('family');
         Route::post('/familyStore', 'familyStore')->name('familyStore');
         Route::get('/address/{user_id}', 'address')->name('address');
         Route::post('/addressStore', 'addressStore')->name('addressStore');
         Route::get('/education/{user_id}', 'education')->name('education');
         Route::post('/educationStore', 'educationStore')->name('educationStore');

         Route::get('/professional/{user_id}', 'professional')->name('professional');
         Route::post('/professionalStore', 'professionalStore')->name('professionalStore');
         Route::get('/financial/{user_id}', 'financial')->name('financial');
         Route::post('/financialStore', 'financialStore')->name('financialStore');

         Route::get('/property/{user_id}', 'property')->name('property');
         Route::post('/propertyStore', 'propertyStore')->name('propertyStore');

         Route::get('/disability/{user_id}', 'disability')->name('disability');
         Route::post('/disabilityStore', 'disabilityStore')->name('disabilityStore');

         Route::get('/freedom/{user_id}', 'freedom')->name('freedom');
         Route::post('/freedomStore', 'freedomStore')->name('freedomStore');

         Route::get('/area/{user_id}', 'area')->name('area');
         Route::post('/areaStore', 'areaStore')->name('areaStore');
    });
    Route::resource('organization-ownership', OrganizationOwnershipController::class);

    Route::get('organizations', function () {
        return redirect()->route('organization.index');
    });
    Route::prefix('organizations')->name('organizationA.')->group(function () {
        Route::resource('trade-license', TradeLicenseController::class);

        Route::get('trade-license/invoice/{id}', [TradeLicenseController::class, 'invoice'])->name('trade-license.invoice');
        Route::get('trade-license/preview/{id}', [TradeLicenseController::class, 'preview'])->name('trade-license.preview');
        Route::get('trade-license/confirmed/{id}', [TradeLicenseController::class, 'confirmedLicense'])->name('trade-license.confirmed');
        Route::post('trade-license/confirmation/{id}', [TradeLicenseController::class, 'licenseConfirmation'])->name('trade-license.confirmation');

        Route::get('get-trade-license', [TradeLicenseController::class, 'getTradeLicense'])->name('trade-license.getTradeLicense');



        Route::resource('registration-fees', OrganizationFeeController::class);
        Route::resource('renew-fees', OrganizationRenewController::class);
    });

    Route::resource('institute', InstituteController::class);

    Route::prefix('institutes')->name('instituteA.')->group(function () {

        Route::get('admin/{id}', [InstituteController::class, 'admin'])->name('adminCreate');
        Route::post('admin-store', [InstituteController::class, 'adminStore'])->name('adminStore');

        Route::get('images/{id}', [InstituteController::class, 'images'])->name('imagesCreate');
        Route::post('images-store', [InstituteController::class, 'imagesStore'])->name('imagesStore');
    });

    Route::resource('institutional-admin', InstitutionalAdminController::class);


    Route::resource('admin', AdminController::class);



    Route::resource('house', HouseController::class);
    Route::resource('house-ownership', HouseOwnershipController::class);

    Route::resource('land', LandController::class);
    Route::resource('vehicle', VehicleController::class);
    Route::resource('market', MarketController::class);
    Route::resource('bridge', BridgeController::class);
    Route::resource('road', RoadController::class);

    Route::resource('tax', TaxController::class);
    Route::post('tax-status', [TaxController::class, 'taxStatus'])->name('tax.status');

    Route::get('taxes', function () {
        return redirect()->route('tax.index');
    });

    Route::prefix('taxes')->name('taxes.')->group(function () {
        Route::resource('tax-year', TaxYearController::class);
        Route::resource('tax-rate', TaxRateController::class);
        Route::get('receipt/{id}', [TaxController::class, 'taxReceipt'])->name('receipt');
        Route::get('received', [TaxController::class, 'taxReceived'])->name('tax.received');
        Route::get('confirmed/{id}', [TaxController::class, 'taxConfirmed'])->name('confirmed');

    });


    Route::resource('marriage', MarriageController::class);
    Route::resource('divorce', DivorceController::class);

    Route::resource('institute-type', InstituteTypeController::class);
    Route::resource('institute-category', InstituteCategoryController::class);

Route::prefix('report')->name('report.')->group(function () {
        Route::get('general', [ReportController::class, 'generalReport'])->name('general-report');
        Route::get('loan', [ReportController::class, 'loanReport'])->name('loan-report');
        Route::get('payment', [ReportController::class, 'paymentReport'])->name('payment-report');
        Route::get('due', [ReportController::class,'dueReport'])->name('due-report');
        Route::get('subsidy', [ReportController::class,'subsidyReport'])->name('subsidy-report');
    });

});



// Clear Cache & Optimize Artisan Routes:
Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return '<h3>Artisan optimize:clear executed successfully!</h3>';
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return '<h3>Artisan optimize executed successfully!</h3>';
});

Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    return '<h3>Artisan cache:clear executed successfully!</h3>';
});

Route::get('/route-clear', function () {
    Artisan::call('route:clear');
    return '<h3>Artisan route:clear executed successfully!</h3>';
});

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return '<h3>Artisan config:clear executed successfully!</h3>';
});

Route::get('/view-clear', function () {
    Artisan::call('view:clear');
    return '<h3>Artisan view:clear executed successfully!</h3>';
});

Route::get('/cc', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return '<h3>All caches (cache, route, config, view, optimize) cleared successfully!</h3>';
});

Route::get('/clear-all', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return '<h3>All caches (cache, route, config, view, optimize) cleared successfully!</h3>';
});

// Run Migration with Secret Key:
Route::get('/run-migrate/{key?}', function (\Illuminate\Http\Request $request, $key = null) {
    $secretKey = env('MIGRATE_SECRET_KEY', 'alms2026secret');
    $providedKey = $key ?? $request->query('key');

    if (!$providedKey || $providedKey !== $secretKey) {
        return response('<h3>Unauthorized Access! Invalid Secret Key.</h3><p>Usage: /run-migrate/YOUR_SECRET_KEY or /run-migrate?key=YOUR_SECRET_KEY</p>', 403);
    }

    try {
        Artisan::call('migrate', ['--force' => true]);
        return '<h3>Artisan migrate executed successfully!</h3><pre>' . Artisan::output() . '</pre>';
    } catch (\Throwable $th) {
        return '<h3>Migration Failed:</h3><pre>' . $th->getMessage() . '</pre>';
    }
});