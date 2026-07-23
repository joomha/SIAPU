<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backup.index');
    }

    public function downloadDb()
    {
        // Simple pure PHP MySQL Dumper to avoid mysqldump PATH issues
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current', json_decode(json_encode($tables), true));
        $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $createTable = DB::select("SHOW CREATE TABLE `{$table}`")[0]->{'Create Table'};
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
            $sql .= $createTable . ";\n\n";

            $rows = DB::table($table)->get();
            $batchSql = '';
            foreach ($rows as $row) {
                $row = (array) $row;
                $keys = array_map(function($key) { return "`{$key}`"; }, array_keys($row));
                $values = array_map(function($value) { 
                    if ($value === null) return 'NULL';
                    // Escape single quotes and backslashes
                    $escaped = str_replace(["\\", "'"], ["\\\\", "\\'"], $value);
                    return "'" . $escaped . "'"; 
                }, array_values($row));

                $batchSql .= "INSERT INTO `{$table}` (" . implode(", ", $keys) . ") VALUES (" . implode(", ", $values) . ");\n";
            }
            $sql .= $batchSql . "\n\n";
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $fileName = 'backup_' . env('DB_DATABASE') . '_' . Carbon::now()->format('Ymd_His') . '.sql';
        $path = storage_path('app/public/' . $fileName);
        file_put_contents($path, $sql);

        activity()
            ->causedBy(auth()->user())
            ->log('Admin mengunduh backup database');

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
