<?php

namespace App\Console\Commands;

use App\Models\Auto;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\EngineType;
use App\Models\GearType;
use App\Models\Mark;
use App\Models\MarkModel;
use App\Models\MarkModelGeneration;
use App\Models\Transmission;
use Exception;
use Illuminate\Console\Command;

class ParseXMLFromFileAndSaveDataToDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:saveData {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сохранить данные об автомобилях в базу данных из файла в формате XML.';

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle()
    {
        $actualOffers = [];
        $path = env("PATH_XML");

        try {
            try {
                if ($this->hasArgument('path') && $this->argument('path')) {
                    $path = $this->argument('path');
                }

                if (!is_file($path)) {
                    throw new Exception("указанный путь не ведёт к файлу.");
                }

                $xml = simplexml_load_file($path);
            } catch (Exception $exception) {
                throw new Exception("Не удалось получить XML, {$exception->getMessage()}");
            }

            if (empty($xml->offers->offer)) {
                throw new Exception("Не верный формат или нет записей");
            }

            $this->alert("Save offers");
            foreach ($xml->offers->offer as $offer) {
                /** @var Auto $auto */

                $actualOffers[] = strval($offer->id);

                try {
                    $auto = Auto::query()->firstOrNew(['id' => $offer->id]);

                    if (!empty($offer->mark)) {
                        $mark = Mark::query()->updateOrCreate(['name' => strval($offer->mark)]);
                        $auto->mark()->associate($mark);
                    } else {
                        $auto->setAttribute('mark_id', null);
                    }

                    if (!empty($offer->model)) {
                        $attributes = ['name' => strval($offer->model)];

                        if (isset($mark)) {
                            $attributes['mark_id'] = $mark->getAttribute('id');
                        } else {
                            $attributes['mark_id'] = null;
                        }

                        $markModel = MarkModel::query()->updateOrCreate($attributes);
                        $auto->markModel()->associate($markModel);
                    } else {
                        $auto->setAttribute('mark_model_id', null);
                    }

                    if (isset($offer->generation)) {
                        $attributes = ['name' => strval($offer->generation)];

                        if (isset($mark)) {
                            $attributes['mark_id'] = $mark->getAttribute('id');
                        } else {
                            $attributes['mark_id'] = null;
                        }

                        if (isset($markModel)) {
                            $attributes['mark_model_id'] = $markModel->getAttribute('id');
                        } else {
                            $attributes['mark_model_id'] = null;
                        }

                        $markModelGeneration = MarkModelGeneration::query()->updateOrCreate($attributes);
                        $auto->markModelGeneration()->associate($markModelGeneration);
                    } else {
                        $auto->setAttribute('mark_model_generation_id', null);
                    }

                    if (!empty($offer->year)) {
                        $auto->setAttribute('year', $offer->year);
                    } else {
                        $auto->setAttribute('year', null);
                    }


                    if (!empty($offer->run)) {
                        $auto->setAttribute('run', floatval($offer->run));
                    } else {
                        $auto->setAttribute('run', null);
                    }

                    if (!empty($offer->color)) {
                        $color = Color::query()->updateOrCreate(['name' => strval($offer->color)]);
                        $auto->color()->associate($color);
                    } else {
                        $auto->setAttribute('color_id', null);
                    }

                    if (!empty($offer->{"body-type"})) {
                        $bodyType = BodyType::query()->updateOrCreate(['name' => strval($offer->{"body-type"})]);
                        $auto->bodyType()->associate($bodyType);
                    } else {
                        $auto->setAttribute('body_type_id', null);
                    }

                    if (!empty($offer->{"engine-type"})) {
                        $engineType = EngineType::query()->updateOrCreate(['name' => strval($offer->{"engine-type"})]);
                        $auto->engineType()->associate($engineType);
                    } else {
                        $auto->setAttribute('engine_type_id', null);
                    }

                    if (!empty($offer->transmission)) {
                        $transmission = Transmission::query()->updateOrCreate(['name' => strval($offer->transmission)]);
                        $auto->transmission()->associate($transmission);
                    } else {
                        $auto->setAttribute('transmission_id', null);
                    }

                    if (!empty($offer->{"gear-type"})) {
                        $gearType = GearType::query()->updateOrCreate(['name' => strval($offer->{"gear-type"})]);
                        $auto->gearType()->associate($gearType);
                    } else {
                        $auto->setAttribute('gear_type_id', null);
                    }

                    $auto->save();

                    $this->info("$offer->id OK");
                } catch (Exception $exception) {
                    $this->error("Не удалось создать запись для offer({$offer->id}) с , {$exception->getMessage()}");
                }
            }

            $this->alert("Delete offers");
            $autos = Auto::query()->whereNotIn('id', $actualOffers)->get();
            foreach ($autos as $auto) {
                $auto->delete();
                $this->info("{$auto->getAttribute('id')} OK");
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
