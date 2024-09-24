<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Results</title>

    <!-- Vite: Load compiled style.css -->
    @vite('resources/css/style.css')

    <!-- Use Google Fonts for Arabic and other text -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Raleway:wght@300;400;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <!-- html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
</head>
<body>

    <div class="app">
        <div class="home results-view" id="results-section">
            
            <!-- Header Image -->
            <img src="{{ asset('images/header.svg') }}" alt="Header Image" class="responsive-header" id="header-image" style="width: 100%; height: auto;">
            
            <h1>{{ $student->name }}</h1>
            
            <div class="results-details">
                <div class="right">
    <p><strong>Roll Number:</strong> <span class="value">{{ $student->roll_number }}</span></p>
    <p><strong>Dars Code:</strong> <span class="value">{{ $student->school_code }}</span></p>
    <p class="category"><strong>Category:</strong> <span class="value">{{ $student->category_code }}</span></p>
</div>

                <div class="left">
                    <p><strong>Total Marks:</strong> {{ $student->total_marks }}</p>
                    <p><strong>Grade:</strong> {{ $student->grade }}</p>
                </div>
            </div>
            
            {{-- <h3>Subjects and Marks</h3> --}}
            
            <table class="results-table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->subjects as $subject)
                        <tr>
                            <td>{{ $subject['subject'] }}</td>
                            <td>{{ $subject['marks'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Exclude from PDF -->
            <div class="message" id="message-section">
                <p>
    
                    وهذا نتيجة لعملك الجاد وجهودك،
                    التي قمت بتحضيرها كثيرًا للامتحان للحصول على أفضل النتائج في هذا الاختبار.
                    هنا قمنا بنشر نتائج ما كسبته وما كتبته في أوراق الامتحان وقت الامتحان.
                    لذا استمر في ذلك وابذل قصارى جهدك من الآن من أجل مستقبل أفضل.
                    
                    </p>
            </div>

            <div class="button-group" id="button-section">
                <div class="button-container">
                    <a href="#" onclick="printResult()">Print Result</a>
                </div>

                <div class="button-container">
                    <a href="#" onclick="downloadAsPDF(event)">Download PDF</a>
                </div>

                <div class="button-container">
                    <a href="{{ route('students.index') }}">Check another result</a>
                </div>
            </div>

            <div class="copyright">
                <p> © SUFFA DARS COORDINATION </p>
            </div>
        </div>
    </div>

    <script>
        function printResult() {
            window.print();
        }

        function downloadAsPDF(event) {
    event.preventDefault(); // Prevent default link behavior

    // Add the class to hide elements that should not be in the PDF
    document.getElementById('message-section').classList.add('hide-for-pdf');
    document.getElementById('button-section').classList.add('hide-for-pdf');

    // Generate PDF
    var element = document.getElementById('results-section'); // The section to convert to PDF

    var opt = {
        margin:       0.5,
        filename:     'result_{{ $student->roll_number }}.pdf',
        image:        { type: 'jpeg', quality: 1.0 },
        html2canvas:  { scale: 3, logging: true, useCORS: true }, // Ensures image rendering
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait', textDirection: 'rtl' }
    };

    html2pdf().from(element).set(opt).save().then(function() {
        // Remove the class to restore visibility after PDF generation
        document.getElementById('message-section').classList.remove('hide-for-pdf');
        document.getElementById('button-section').classList.remove('hide-for-pdf');
    });
}

    </script>

</body>
</html>
