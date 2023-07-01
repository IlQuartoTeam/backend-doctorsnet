<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $reviews = [
            [
                'doctor_id' => 1,
                'email' => 'francesco@gmail.com',
                'name' => 'Francesco Paoli',
                'rating' => '4',
                'text' => "Mi sono trovato molto bene con questo medico, è molto apprensivo e ci tiene al paziente!"
            ],
            [
                'doctor_id' => 1,
                'email' => 'giulia@gmail.com',
                'name' => 'Giulia Rossi',
                'rating' => '5',
                'text' => "Il dottore è estremamente competente e cordiale. Ha risposto a tutte le mie domande in modo chiaro e esaustivo."
            ],
            [
                'doctor_id' => 1,
                'email' => 'mario@gmail.com',
                'name' => 'Mario Bianchi',
                'rating' => '3',
                'text' => "Ho avuto un'esperienza altalenante con questo medico. A volte sembrava poco interessato alle mie preoccupazioni."
            ],
            [
                'doctor_id' => 2,
                'email' => 'anna@gmail.com',
                'name' => 'Anna Verdi',
                'rating' => '4',
                'text' => "Il medico è stato molto gentile e ha spiegato in dettaglio tutte le possibili opzioni di trattamento."
            ],
            [
                'doctor_id' => 2,
                'email' => 'luca@gmail.com',
                'name' => 'Luca Esposito',
                'rating' => '2',
                'text' => "Sono rimasto deluso dall'atteggiamento del medico. Non sembrava interessato alle mie preoccupazioni e mi ha dato poche informazioni."
            ],
            [
                'doctor_id' => 3,
                'email' => 'giorgia@gmail.com',
                'name' => 'Giorgia Ferri',
                'rating' => '5',
                'text' => "Il dottore è stato eccezionale! Ha dimostrato grande empatia e mi ha fornito un'ottima assistenza medica."
            ],
            [
                'doctor_id' => 4,
                'email' => 'marco@gmail.com',
                'name' => 'Marco Giallo',
                'rating' => '4',
                'text' => "Ho avuto una buona esperienza con questo medico. È stato puntuale e mi ha fornito un trattamento efficace."
            ],
            [
                'doctor_id' => 4,
                'email' => 'paola@gmail.com',
                'name' => 'Paola Rosa',
                'rating' => '5',
                'text' => "Consiglio vivamente questo medico. È molto competente e ha un'ottima capacità di ascolto."
            ],
            [
                'doctor_id' => 4,
                'email' => 'giovanni@gmail.com',
                'name' => 'Giovanni Neri',
                'rating' => '3',
                'text' => "Mi aspettavo di più da questo medico. Non mi ha fornito molte informazioni sul mio problema di salute."
            ],
            [
                'doctor_id' => 5,
                'email' => 'elena@gmail.com',
                'name' => 'Elena Bianchi',
                'rating' => '4',
                'text' => "Sono rimasta soddisfatta del trattamento ricevuto da questo medico. È stato professionale e mi ha fatto sentire a mio agio."
            ],
            [
                'doctor_id' => 6,
                'email' => 'andrea@gmail.com',
                'name' => 'Andrea Verde',
                'rating' => '5',
                'text' => "Il medico è stato molto gentile e disponibile. Ha risposto a tutte le mie domande e ha dissipato i miei dubbi."
            ],
            [
                'doctor_id' => 7,
                'email' => 'camilla@gmail.com',
                'name' => 'Camilla Ricci',
                'rating' => '4',
                'text' => "Mi sono trovata molto bene con questo medico. È stato paziente nel rispondere alle mie domande e mi ha dato consigli utili."
            ],
            [
                'doctor_id' => 8,
                'email' => 'lorenzo@gmail.com',
                'name' => 'Lorenzo Marroni',
                'rating' => '2',
                'text' => "Non sono rimasto soddisfatto del trattamento ricevuto da questo medico. Non sembrava interessato ai miei sintomi."
            ],
            [
                'doctor_id' => 9,
                'email' => 'valentina@gmail.com',
                'name' => 'Valentina Fabbri',
                'rating' => '5',
                'text' => "Ho avuto una grande esperienza con questo medico. È stato molto attento e mi ha fornito un'ottima cura."
            ],
            [
                'doctor_id' => 10,
                'email' => 'fabio@gmail.com',
                'name' => 'Fabio Gatti',
                'rating' => '4',
                'text' => "Il medico ha dimostrato grande professionalità. Ha dedicato tempo a spiegare il mio quadro clinico in modo chiaro."
            ],
            [
                'doctor_id' => 10,
                'email' => 'chiara@gmail.com',
                'name' => 'Chiara Marrone',
                'rating' => '3',
                'text' => "Sono stata un po' delusa da questo medico. Non mi ha fornito molte informazioni sulla mia condizione di salute."
            ],
            [
                'doctor_id' => 10,
                'email' => 'maria@gmail.com',
                'name' => 'Maria Bianco',
                'rating' => '4',
                'text' => "Mi sono trovata molto bene con questo medico. È stato gentile e mi ha dato consigli preziosi."
            ],
            [
                'doctor_id' => 10,
                'email' => 'alessandro@gmail.com',
                'name' => 'Alessandro Verdi',
                'rating' => '5',
                'text' => "Il dottore è stato molto competente e disponibile. Ha risolto il mio problema di salute in modo rapido ed efficace."
            ],
            [
                'doctor_id' => 11,
                'email' => 'giorgio@gmail.com',
                'name' => 'Giorgio Rossi',
                'rating' => '3',
                'text' => "Non sono rimasto completamente soddisfatto con questo medico. Non mi ha dato tutte le risposte che cercavo."
            ],
            [
                'doctor_id' => 12,
                'email' => 'federica@gmail.com',
                'name' => 'Federica Esposito',
                'rating' => '5',
                'text' => "Il medico è stato fantastico! È stato molto attento e mi ha fornito una cura di alta qualità."
            ],
            [
                'doctor_id' => 13,
                'email' => 'davide@gmail.com',
                'name' => 'Davide Ferri',
                'rating' => '4',
                'text' => "Mi sono sentito molto confortato durante la visita con questo medico. Ha dimostrato una grande empatia."
            ],
            [
                'doctor_id' => 14,
                'email' => 'caterina@gmail.com',
                'name' => 'Caterina Gialli',
                'rating' => '5',
                'text' => "Consiglio vivamente questo medico. È stato molto professionale e mi ha fornito un'ottima assistenza."
            ],
            [
                'doctor_id' => 15,
                'email' => 'stefano@gmail.com',
                'name' => 'Stefano Rosa',
                'rating' => '3',
                'text' => "Sono un po' deluso dall'esperienza con questo medico. Non ha speso molto tempo ad ascoltare le mie preoccupazioni."
            ],
            [
                'doctor_id' => 15,
                'email' => 'giulia@gmail.com',
                'name' => 'Giulia Neri',
                'rating' => '4',
                'text' => "Il medico è stato molto competente e ha risposto a tutte le mie domande in modo esaustivo."
            ],
            [
                'doctor_id' => 15,
                'email' => 'luigi@gmail.com',
                'name' => 'Luigi Bianchi',
                'rating' => '2',
                'text' => "Sono rimasto deluso dalla visita con questo medico. Non sembrava interessato ai miei sintomi."
            ],
            [
                'doctor_id' => 15,
                'email' => 'sara@gmail.com',
                'name' => 'Sara Verdi',
                'rating' => '5',
                'text' => "Ho avuto una fantastica esperienza con questo medico. È stato molto professionale e mi ha fornito una cura eccezionale."
            ],
            [
                'doctor_id' => 16,
                'email' => 'roberto@gmail.com',
                'name' => 'Roberto Gatti',
                'rating' => '4',
                'text' => "Il dottore è stato molto gentile e ha spiegato in modo chiaro il mio problema di salute."
            ],
            [
                'doctor_id' => 17,
                'email' => 'laura@gmail.com',
                'name' => 'Laura Marrone',
                'rating' => '5',
                'text' => "Sono rimasta molto soddisfatta del trattamento ricevuto da questo medico. È stato molto professionale."
            ],
            [
                'doctor_id' => 18,
                'email' => 'paolo@gmail.com',
                'name' => 'Paolo Bianco',
                'rating' => '3',
                'text' => "Non sono completamente soddisfatto con questo medico. Non ha speso abbastanza tempo ad ascoltare le mie preoccupazioni."
            ],
            [
                'doctor_id' => 19,
                'email' => 'elisa@gmail.com',
                'name' => 'Elisa Verdi',
                'rating' => '4',
                'text' => "Mi sono trovata molto bene con questo medico. È stato attento alle mie necessità e mi ha fornito una cura adeguata."
            ],
            [
                'doctor_id' => 20,
                'email' => 'antonio@gmail.com',
                'name' => 'Antonio Rossi',
                'rating' => '5',
                'text' => "Il medico è stato eccezionale! Ha dimostrato grande competenza e mi ha fornito un'assistenza di prima classe."
            ],
            [
                'doctor_id' => 21,
                'email' => 'federico@gmail.com',
                'name' => 'Federico Esposito',
                'rating' => '4',
                'text' => "Ho avuto una buona esperienza con questo medico. È stato chiaro nelle spiegazioni e mi ha dato consigli utili."
            ],
            [
                'doctor_id' => 22,
                'email' => 'eleonora@gmail.com',
                'name' => 'Eleonora Giallo',
                'rating' => '3',
                'text' => "Sono rimasta un po' delusa dall'esperienza con questo medico. Non sembrava molto interessato ai miei sintomi."
            ],
        ];


            foreach ($reviews as $review) {
                    DB::table('reviews')->insert([
                        'doctor_id' => $review['doctor_id'],
                        'email' => $review['email'],
                        'name' => $review['name'],
                        'rating' => $review['rating'],
                        'text' => $review['text']
                    ]);

            }


    }
}
