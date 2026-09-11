<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Region</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset('backends/assets/images/cwc-log.jpg') }}">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg p-4">
    <h3 class="mb-4">Edit Region</h3>

    <form method="POST" action="{{ route('update.region', $region->id) }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Region Name</label>
        <input type="text" name="name" class="form-control" value="{{ $region->name }}" required>
      </div>

      <button type="submit" class="btn btn-success">Update</button>
      <a href="{{ route('all.region') }}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>

</body>
</html>
