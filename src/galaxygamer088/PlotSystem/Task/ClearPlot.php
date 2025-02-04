<?php

namespace galaxygamer088\PlotSystem\Task;

use galaxygamer088\PlotSystem\Options;
use pocketmine\block\BlockFactory;
use pocketmine\math\Vector3;
use pocketmine\scheduler\Task;
use pocketmine\world\World;

class ClearPlot extends Task{

public World $world;
public array $plotId;

    public function __construct(World $world, array $plotId){
        $this->world = $world;
        $this->plotId = $plotId;
    }

    public function onRun() : void{
        for($x = 0; $x <= Options::PLOT_SIZE - 1; $x++){
            for($z = 0; $z <= Options::PLOT_SIZE - 1; $z++){
                for($y = 0; $y <= 255; $y++){
                    $X = $this->plotId[0] * Options::TOTAL_SIZE + $x;
                    $Z = $this->plotId[1] * Options::TOTAL_SIZE + $z;

                    if($y == 0){
                        $bottomBlock = BlockFactory::getInstance()->get(Options::PLOT_BOTTOM_BLOCK_ID, Options::PLOT_BOTTOM_BLOCK_META);
                        if($this->world->getBlock(new Vector3($X, $y, $Z))->getFullId() !== $bottomBlock->getFullId()){
                            $this->world->setBlockAt($X, $y, $Z, $bottomBlock);
                        }
                    }elseif($y == Options::GROUND_HEIGHT){
                        $floorBlock = BlockFactory::getInstance()->get(Options::PLOT_FLOOR_BLOCK_ID, Options::PLOT_FLOOR_BLOCK_META);
                        if($this->world->getBlock(new Vector3($X, $y, $Z))->getFullId() !== $floorBlock->getFullId()){
                            $this->world->setBlockAt($X, $y, $Z, $floorBlock);
                        }
                    }elseif($y < Options::GROUND_HEIGHT){
                        $fillBlock = BlockFactory::getInstance()->get(Options::PLOT_FILL_BLOCK_ID, Options::PLOT_FILL_BLOCK_META);
                        if($this->world->getBlock(new Vector3($X, $y, $Z))->getFullId() !== $fillBlock->getFullId()){
                            $this->world->setBlockAt($X, $y, $Z, $fillBlock);
                        }
                    }else{
                        $airBlock = BlockFactory::getInstance()->get(0, 0);
                        if($this->world->getBlock(new Vector3($X, $y, $Z))->getFullId() !== $airBlock->getFullId()){
                            $this->world->setBlockAt($X, $y, $Z, $airBlock);
                        }
                    }
                }
            }
        }
    }
}