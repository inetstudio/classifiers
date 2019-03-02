<?php

namespace InetStudio\Classifiers\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Class MoveClassifiersToNew.
 */
class MoveClassifiersToNew extends Command
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:classifiers:update';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Update package';

    /**
     * Запуск команды.
     *
     * @return void
     */
    public function handle(): void
    {
        $groupsService = app()->make('InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract');

        $now = Carbon::now()->format('Y-m-d H:m:s');
        $oldItems = DB::table('classifiers')->select('*')->get();

        foreach ($oldItems as $oldItem) {
            $groupName = $oldItem->type;

            $group = $groupsService->model::updateOrCreate([
                'name' => $groupName,
            ], [
                'alias' => strtolower(str_replace(' ', '_', $this->transliterate($groupName))),
            ]);

            DB::connection('mysql')->table('classifiers_entries')->insert([[
                'id' => $oldItem->id,
                'value' => $oldItem->value,
                'alias' => $oldItem->alias,
                'created_at' => $now,
                'updated_at' => $now,
            ]]);

            $group->entries()->attach($oldItem->id);
        }
    }

    private function transliterate($input){ $gost = array( "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d", "е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i", "й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n", "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t", "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u", "я"=>"ya", "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D", "Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I", "Й"=>"I","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N", "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T", "У"=>"Y","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"Ch", "Ш"=>"Sh","Щ"=>"Sh","Ы"=>"I","Э"=>"E","Ю"=>"U", "Я"=>"Ya", "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"", "ї"=>"j","і"=>"i","ґ"=>"g","є"=>"ye", "Ї"=>"J","І"=>"I","Ґ"=>"G","Є"=>"YE" ); return strtr($input, $gost); }
}
