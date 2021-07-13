<?php

namespace Database\Seeders;
use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\Day;
use App\Models\Service;
use App\Models\Training;
use App\Models\TrainingApply;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GeneralDataSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $teachers = User::whereHas('roles', function ($query) {
            $query->where('id',3);
        })->get()->pluck('id')->toArray();
        $days = Day::all()->pluck('id')->toArray();
        $students = User::whereHas('roles', function ($query) {
            $query->where('id',config('panel.registration_default_role'));
        })->get();
        $trainings = Training::where('is_active',2)->get()->pluck('id')->toArray();
        $business_categories = BusinessCategory::all()->pluck( 'id')->toArray();


//
//        for ($i = 1; $i < 20; $i++) { //training add
//            $training = [
//                'is_active' =>  $faker->randomElement([1,2,3,4,5]),
//                'title'          => $faker->paragraph(1),
//                'description'       =>  $faker->realText(250,2),
//                'duration' => $faker->randomElement(['3 Month','2 Month','6 Month']),
//                'start_date'           => date('Y-m-d'),
//                'end_date'           => '2021-10-30',
//                'outcome'        => $faker->paragraph(5),
//                'created_at' => Carbon::now()->toDateTimeString(),
//                'updated_at' => Carbon::now()->toDateTimeString(),
//            ];
//            $training = Training::create($training);
//            $teacher['user_id'] = $faker->randomElement($teachers);
//            $day['day_id'] = $faker->randomElement($days);
//            $training->users()->sync($teacher);
//                foreach ($day as $key => $day_id) {
//                    $training->days()->attach($day_id, array('begin_time' => '10:00:00', 'close_time' => '12:00:00'));
//                }
//        }
//
//
//        for ($i = 1; $i < 10; $i++) {// user add
//            $users = [
//                'name'           => $faker->firstName.' '.$faker->lastName,
//                'email'          => $faker->email,
//                'password'       => bcrypt('password'),
//                'remember_token' => null,
//                'verified'           => 1,
//                'verified_at'        => '2021-01-19 07:48:34',
//                'verification_token' => '',
//                'approved'           => 1,
//                'created_at' => Carbon::now()->toDateTimeString(),
//                'updated_at' => Carbon::now()->toDateTimeString(),
//            ];
//            $user = User::create($users);
//        }
//
//
//        foreach ($students as $key=> $student){ //training apply
//            for ($i=0; $i<count($trainings); $i++){
//                $training['training_id'] = $faker->randomElement($trainings);
//                    $training['user_id'] = $student->id;
//                    $user = TrainingApply::where('user_id',$training['user_id'])->where('training_id',$training['training_id'])->first();
//                    if (!$user){
//                        TrainingApply::create($training);
//                    }
//            }
//        }
//
//
//        foreach ($students as $key=> $student){ //bussiness add
//            for ($i=0; $i<2; $i++) {
//                $business = [
//                    'user_id' => $student->id,
//                    'name' => $faker->paragraph(1),
//                    'summary' => $faker->realText(250, 2),
//                    'location' => $faker->address,
//                    'created_at' => Carbon::now()->toDateTimeString(),
//                    'updated_at' => Carbon::now()->toDateTimeString(),
//                ];
//
//                $business = Business::create($business);
//                $businessCategory = array();
//                for ($i = 0; $i < 3; $i++) {
//                    array_push($businessCategory, $faker->randomElement($business_categories));
//                }
//                $businessCategory = array_unique($businessCategory);
//                $business->business_categories()->sync($businessCategory);
//            }
//        }



        foreach ($students as $key=> $student){ //service add
            for ($i=0; $i<2; $i++) {
                $service = [
                    'user_id' => $student->id,
                    'name' => $faker->paragraph(1),
                    'description' => $faker->realText(250, 2),
                    'service_status_id' => 1,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
                $service = Service::create($service);
            }
        }
    }
}
