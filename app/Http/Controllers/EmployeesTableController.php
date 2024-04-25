<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Employee; // Assuming you have a model named Employee
use DateTime;

class EmployeesTableController extends Controller
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
{
    public function index()
    {
        // Fetch all employees from the database
        $employees = Employee::all();

        // Process the data
        $data = [];

        foreach ($employees as $employee) {
            // Extract year, month, and week from data_hyrje
            $year = date('Y', strtotime($employee->data_hyrje));
            $month = date('F', strtotime($employee->data_hyrje)); // 'F' for full textual representation of a month
            $week = date('W', strtotime($employee->data_hyrje)); // ISO-8601 week number of year
            $weekDay = date('D d', strtotime($employee->data_hyrje));

            // Extract start and end times
            $startDateTime = $employee->data_hyrje . ' ' . $employee->ora_hyrje;
            $endDateTime = $employee->data_dalje . ' ' . $employee->ora_dalje;

            // Check if ora_dalje is '00:00:00' and adjust to '18:00:00' if so
            if ($employee->ora_dalje == '00:00:00') {
                $endDateTime = $employee->data_dalje . ' 18:00:00';
            }

            // Create DateTime objects
            $start = new DateTime($startDateTime);
            $end = new DateTime($endDateTime);

            // Calculate the interval
            $interval = $start->diff($end);

            // Convert interval to total hours
            $hours = $interval->days * 24 + $interval->h + ($interval->i / 60);

            // Aggregate data
            $data[$employee->username]['total'] = ($data[$employee->username]['total'] ?? 0) + $hours;
            $data[$employee->username][$year][$month][$week][$weekDay]['total'] = ($data[$employee->username][$year][$month][$week][$weekDay]['total'] ?? 0) + $hours;
            $data[$employee->username][$year][$month][$week][$weekDay]['date'] = $weekDay;
            $data[$employee->username][$year][$month][$week]['total'] = ($data[$employee->username][$year][$month][$week]['total'] ?? 0) + $hours;
            $data[$employee->username][$year][$month][$week]['week'] = $week;
            $data[$employee->username][$year][$month]['total'] = ($data[$employee->username][$year][$month]['total'] ?? 0) + $hours;
            $data[$employee->username][$year][$month]['month'] = $month;
            $data[$employee->username][$year]['total'] = ($data[$employee->username][$year]['total'] ?? 0) + $hours;
            $data[$employee->username][$year]['year'] = $year;

            // Other info
            $data[$employee->username]['emri'] = $employee->nome;
            $data[$employee->username]['mbiemri'] = $employee->cognome;
            $data[$employee->username]['username'] = $employee->username;
        }

        // Prepare the JSON response
        $json_data = [
            "data" => array_values($data),
            "draw" => 1,
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data), // For simplicity, we'll use totalData. Adjust if you implement filtering.
        ];

        return response()->json($json_data);
    }
}
