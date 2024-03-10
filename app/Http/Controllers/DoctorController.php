<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    //
    function index(){
        $doctors = User::with('patients')->where('role','doctor')->get();

        foreach ($doctors as $doctor) {
            echo $doctor->name;
            echo '<br>';
            foreach ($doctor->patients as $patient) {
                echo '&nbsp;&nbsp;'.$patient->name;
                echo '<br>';
            }
            echo '<hr>';
        }
        exit;
    }

    function create(){
        $doctor = User::create([
            'name'=>'Dr. Tasnin',
            'email'=>'qTqJ9@example.com',
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role'=>'doctor',
            ]);

        $patients = [
                        [
                            'name'=>'Patient A',
                            'email'=>'qTqJ956@example.com',
                            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                            'role'=>'patient',
                        ],
                        [
                            'name'=>'Patient B',
                            'email'=>'qTqJ957@example.com',
                            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                            'role'=>'patient',
                        ]
                    ];
        $doctor->patients()->createMany($patients);

        return redirect('/doctors');

    }

    public function edit(User $doctor) {

        $doctor->load('patients');

        $updatedPatients = [
            [
                'name'=>'Patient AB',
                //'email'=>'qTqJ956@example.com',
                'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                //'role'=>'patient',
            ],
            [
                'name'=>'Patient BC',
                //'email'=>'qTqJ957@example.com',
                'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                //'role'=>'patient',
            ]
        ];

        $doctor->update(['name' => 'Dr. John Smith Doe']);

        $i = 0;
        // accessing a relationship $doctor->patient instead of Calling a method $doctor->patients()
        foreach ( $doctor->patients as $patient) {
            // Handling the case where the number of patients is less than $updatedPatients
            // $doctor->patients may not be the same as the number of elements in $updatedPatients.
            if ($i < count($updatedPatients)) {
                $patient->update($updatedPatients[$i]);
                $i++;
            } else {
                break;
            }
        }
        return redirect('doctors');
    }

    public function delete(User $doctor) {
        $doctor->load('patients');

        if( $doctor->patients->isNotEmpty() ) {
            $doctor->patients->each(function ($patient) use ($doctor) {
                $doctor->patients()->detach($patient->id);
                $patient->delete();
            });
        }
        $doctor->delete();

        return redirect('doctors');
    }

}
