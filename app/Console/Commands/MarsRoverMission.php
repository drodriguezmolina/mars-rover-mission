<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Map;

class MarsRoverMission extends Command
{
    private $map;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'start:mars_rover_mission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @param Map $map
     */
    public function __construct(Map $map)
    {
        parent::__construct();
        $this->map = $map;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->map->create();
        do{
            try{
                $this->info('Rovers position: ' . $this->map->getRoversCell()->toString());
                $this->info('Obstacles: ' . $this->map->getObstaclesPositions());
                $actions = $this->ask('Actions: (F,L,R)');
                $this->map->move($actions);
                $this->info($this->map->getRoversCell()->toString());
            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            $continue = $this->ask('Continue making movements? (Y/N)');
        }while(strtoupper($continue) !== "N");
        return Command::SUCCESS;
    }
}
