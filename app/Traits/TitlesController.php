<?php


namespace App\Traits;

use App\Models\Qualifiers\Media;
use Illuminate\Support\Facades\URL;

trait TitlesController
{
    public function start($channel) {
        $url      = url()->current();
        $url_path = parse_url($url, PHP_URL_PATH);
        $basename = explode('/', $url_path);

        if($basename[1] == 'filmes') {
            $table = 'movies';
            $header = 'Filmes';
        } else {
            $table = 'series';
            $header = 'Séries';
        }

        $c_media = new Media();
        $media = $c_media->streams();
        $subheader = $c_media->where('slug', $channel)->first()->name;

        return view('titles', compact('table', 'header', 'subheader', 'media'));
    }
    public function titlesStart($channel, $pp) {
        return $this->table->titlesStart($channel, $pp);
    }

    public function titlesPage($channel, $page, $pp) {
        return $this->table->titlesPage($channel, $page, $pp);
    }

    public function cast($id)
    {
        return $this->table->cast($id);
    }

    public function producers($id) {
        return $this->table->producers($id);
    }
}
