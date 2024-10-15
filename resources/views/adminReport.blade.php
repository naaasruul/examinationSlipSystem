@include('commons.admin_header')

<style>
    @media print {
        /* Ensure the body background is white */
        body {
            background-color: white;
            display: flex;
            flex-direction: column;
            width: 100%;
            align-items: center;
        }

        .container {
            margin: 0;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Hide non-essential elements for printing (e.g., buttons, navbar) */
        .btn,
        .d-flex,
        footer,
        form,
        nav, /* Hide navbar */
        .formResult,
        .navbar,.navbar-expand-lg ,.bg-body-tertiary {
            display: none;
        }

        /* Optionally, style your printed content */
        .reportResult {
            display: block; /* Ensure the report is displayed */
        }
    }
</style>

<div class="container formResult">
    <h2>Select Year and Class</h2>

    <!-- Form for selecting year and class -->
    <form action="{{ route('adminReport') }}" method="GET">
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <select class="form-select" id="year" name="year">
                <option value="" disabled selected>Select Year</option>
                @foreach($years as $year)
                <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="class" class="form-label">Class</label>
            <select class="form-select" id="class" name="class" disabled>
                <option value="" disabled selected>Select Class</option>
                <!-- Classes will be dynamically populated based on the selected year -->
            </select>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <select class="form-select" id="subject" name="subject">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Monitor</button>
    </form>
</div>

<div class="container reportResult mt-3">
    @if(isset($successData))
    <h3>Success Rate for {{ $selectedClass->className }} - {{ $selectedSubject->subjectName }}</h3>
    <table class="charts-css bar column data-outside">
        <caption>Success Rate of Students</caption>

        <thead>
            <tr>
                <th scope="col">Student Name</th>
                <th scope="col">Success Rate (%)</th>
            </tr>
        </thead>

        <tbody>
            @foreach($successData as $studentSuccess)
            <tr>
                <th scope="row">{{ $studentSuccess['name'] }}</th>
                <td style="--size: {{ $studentSuccess['percentage'] / 100 }};" class="highlighted">
                    <span class="data">{{ $studentSuccess['name'] }} <br> {{ $studentSuccess['percentage'] }}% </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center align-items-center">
        <button onclick="window.print()" class="btn mt-3 btn-primary">Print</button>
    </div>
    @endif
</div>

<!-- Include charts.css -->
<!-- jQuery (for dynamic class selection) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $('#year').on('change', function() {
        let year = $(this).val();

        // Fetch the classes based on the selected year
        $.ajax({
            url: "{{ route('getClasses') }}", // Create this route in web.php
            type: 'GET',
            data: { year: year },
            success: function(data) {
                $('#class').prop('disabled', false);
                $('#class').empty();
                $('#class').append('<option value="" disabled selected>Select Class</option>');
                data.forEach(function(classObj) {
                    $('#class').append('<option value="' + classObj.id + '">' + classObj.className + '</option>');
                });
            }
        });
    });
</script>

@include('commons.footer')
