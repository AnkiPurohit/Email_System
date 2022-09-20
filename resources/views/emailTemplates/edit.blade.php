@extends('../layouts/page')

@section('content')
<div class="container p-3 ">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Create Template</div>


                <div class="card-body">

                    @if (session()->has('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                    @endif
                </div>

                <div class="card-body">
                    @if (session()->has('message'))

                    <div class="alert alert-success">

                        {{ session('message') }}

                    </div>

                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <br />
                    @endif
                    <form method="post" action="{{ route('email-templates.update') }}">
                        <div class="form-group">
                            @csrf
                            <label for="name">Template Name: *</label>
                            <input type="text" class="form-control" name="name" onkeyup="listingslug(this.value)" value="{{ $emailTemplate->name }}" />
                            <input type="hidden" name="id" value="{{ $emailTemplate->id }}" />
                        </div>
                        <div class="form-group">
                            <label for="template_key">Template Key: *</label>
                            <input type="text" class="form-control" name="template_key" id="template_key" value="{{ $emailTemplate->template_key }}" />
                        </div>
                        <div class="form-group">
                            <label for="subject">Eamil Subject : *</label>
                            <input type="text" class="form-control" name="subject" value="{{ $emailTemplate->subject }}" />
                        </div>
                        <div class="form-group">
                            <label for="body">Eamil Body : * </label><span> Add dynamic variable wrapped with double curly brackets</span>
                            <textarea id="editor" name="body" rows="4" cols="50"> {{ $emailTemplate->body }} </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    function slugify(text) {
        return text
            .toString() // Cast to string
            .toLowerCase() // Convert the string to lowercase letters
            .normalize('NFD') // The normalize() method returns the Unicode Normalization Form of a given string.
            .trim() // Remove whitespace from both sides of a string
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
            .replace(/\-\-+/g, '-'); // Replace multiple - with single -
    }

    function listingslug(text) {
        document.getElementById("template_key").value = slugify(text);
    }
</script>

<script>
    tinymce.init({
        selector: 'textarea#editor',
    });
</script>


@endsection