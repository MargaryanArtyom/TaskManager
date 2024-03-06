<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\UserTask;
use Illuminate\Database\Seeder;

class UserTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $tasks = Task::all();

        foreach ($users as $user) {
            $shuffledTasks = $tasks->shuffle();
            $selectedTasks = $shuffledTasks->take(10);

            foreach ($selectedTasks as $task) {
                UserTask::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                ]);
            }
        }
    }
}
