@component('mail::message')
# Jawaban Baru Pada Ujian Kelas Anda

Jawaban baru telah dikirim oleh seseorang pada ujian kelas anda yang berjudul "{$item->course_exam_course->title}". Segera lihat detail jawaban melalui tombol di bawah

@component('mail::button', ['url' => route('dashboard.mentor.course.exam.answer.show', $hash->encodeHex($item->id))])
Detail Jawaban
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
