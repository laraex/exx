<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Des</th>
    </tr>
    </thead>
    <tbody>
    @foreach($faqs as $faq)
        <tr>
            <td>{{ $faq->title }}</td>
            <td>{{ $faq->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>