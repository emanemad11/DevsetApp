<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionsSeeder extends Seeder
{
    public function run()
    {
        // Define questions for different quizzes
        $quizzes = [
            'Taylor Quiz' => [
                ['question' => 'لا أتعرض للتعب بسرعة.', 'correct_answer' => true],
                ['question' => 'أعتقد أنني لست أكثر توتراً من الآخرين.', 'correct_answer' => true],
                ['question' => 'لدي القليل جداً من الصداع.', 'correct_answer' => true],
                ['question' => 'أعمل تحت ضغط كبير.', 'correct_answer' => false],
                ['question' => 'غالباً ما ألاحظ أن يدي ترتجف عندما أحاول القيام بشيء ما.', 'correct_answer' => false],
                ['question' => 'لا أتحول إلى اللون الأحمر أكثر من الآخرين.', 'correct_answer' => true],
                ['question' => 'أعاني من الإسهال مرة واحدة في الشهر أو أكثر.', 'correct_answer' => false],
                ['question' => 'أشعر بالقلق كثيرًا بشأن حوادث محتملة.', 'correct_answer' => true],
                ['question' => 'نادراً ما أتحول إلى اللون الأحمر.', 'correct_answer' => true],
                ['question' => 'غالبًا ما أشعر بالخوف من أن أتحول إلى اللون الأحمر.', 'correct_answer' => true],
                ['question' => 'يدي وقدمي عادةً دافئتان بما فيه الكفاية.', 'correct_answer' => true],
                ['question' => 'أعرق بسهولة حتى في الأيام الباردة.', 'correct_answer' => false],
                ['question' => 'أحيانًا عندما أشعر بالحرج، أتعرض للعرق.', 'correct_answer' => false],
                ['question' => 'نادراً ما ألاحظ قلبي ينبض، ونادراً ما أشعر بضيق في التنفس.', 'correct_answer' => true],
                ['question' => 'أشعر بالجوع تقريبًا طوال الوقت.', 'correct_answer' => true],
                ['question' => 'نادراً ما أعاني من الإمساك.', 'correct_answer' => true],
                ['question' => 'لدي الكثير من مشاكل المعدة.', 'correct_answer' => false],
                ['question' => 'مررت بفترات فقدت فيها النوم بسبب القلق.', 'correct_answer' => true],
                ['question' => 'أشعر بالحرج بسهولة.', 'correct_answer' => false],
                ['question' => 'أنا أكثر حساسية من معظم الناس.', 'correct_answer' => true],
                ['question' => 'غالبًا ما أجد نفسي أقلق بشأن شيء ما.', 'correct_answer' => true],
                ['question' => 'أتمنى أن أكون سعيدًا كما يبدو على الآخرين.', 'correct_answer' => false],
                ['question' => 'أنا عادةً هادئ وغير متوتر بسهولة.', 'correct_answer' => true],
                ['question' => 'أشعر بالقلق بشأن شيء أو شخص ما تقريبًا طوال الوقت.', 'correct_answer' => true],
                ['question' => 'أنا سعيد معظم الوقت.', 'correct_answer' => false],
                ['question' => 'يجعلني الانتظار متوترًا.', 'correct_answer' => true],
                ['question' => 'أحيانًا أشعر بالإثارة لدرجة تجعلني أجد صعوبة في النوم.', 'correct_answer' => true],
                ['question' => 'أحيانًا أشعر أن الصعوبات تتزايد حتى لا أستطيع التغلب عليها.', 'correct_answer' => true],
                ['question' => 'أعترف أنني شعرت بالقلق بشكل مفرط بشأن أمور صغيرة.', 'correct_answer' => true],
                ['question' => 'لدي عدد قليل جدًا من المخاوف مقارنة بأصدقائي.', 'correct_answer' => true],
                ['question' => 'أشعر بعدم الفائدة في بعض الأحيان.', 'correct_answer' => false],
                ['question' => 'أجد صعوبة في التركيز على مهمة أو عمل.', 'correct_answer' => false],
                ['question' => 'أنا عادةً خجول.', 'correct_answer' => false],
                ['question' => 'أميل إلى أخذ الأمور بشكل صعب.', 'correct_answer' => true],
                ['question' => 'أحيانًا أعتقد أنني لا قيمة لي على الإطلاق.', 'correct_answer' => false],
                ['question' => 'أشعر بأنني أفتقر تمامًا إلى الثقة بالنفس.', 'correct_answer' => false],
                ['question' => 'أحيانًا أشعر أنني على وشك الانهيار.', 'correct_answer' => false],
                ['question' => 'أنا واثق تمامًا من نفسي.', 'correct_answer' => true],
            ],

            'Physical Health Quiz' => [
                ['question' => 'يدي وقدمي عادةً دافئتان بما فيه الكفاية.', 'correct_answer' => true],
                ['question' => 'أعرق بسهولة حتى في الأيام الباردة.', 'correct_answer' => false],
                ['question' => 'أحيانًا عندما أشعر بالحرج، أتعرض للعرق.', 'correct_answer' => false],
                ['question' => 'نادراً ما ألاحظ قلبي ينبض، ونادراً ما أشعر بضيق في التنفس.', 'correct_answer' => true],
                ['question' => 'أشعر بالجوع تقريبًا طوال الوقت.', 'correct_answer' => true],
            ],
        ];

        // Loop through each quiz and its associated questions
        foreach ($quizzes as $quizName => $questions) {
            foreach ($questions as $question) {
                Question::create([
                    'question' => $question['question'],
                    'quiz_name' => $quizName,
                    'correct_answer' => $question['correct_answer'],
                ]);
            }
        }
    }
}
