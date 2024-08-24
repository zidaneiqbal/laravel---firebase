@extends('content/display/layouts/mainLayout')

@section('title', 'Chat with Gemini')

@section('content')
<div class="container-fluid py-5 min-vh-100" style="background-color: #55423d;">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center bg-dark text-white">
          Chat with Gemini
        </div>

        <div class="card-body" id="chat-box" style="height: 400px; overflow-y: scroll;">
          <!-- Chat messages will be displayed here -->
        </div>

        <div class="card-footer">
          <form id="chat-form">
            <div class="input-group">
              <input type="text" id="chat-input" class="form-control" placeholder="Type a message..." aria-label="Type a message" aria-describedby="button-send">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="button-send">Send</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('button-send').addEventListener('click', function() {
        let chatInput = document.getElementById('chat-input');
        let chatBox = document.getElementById('chat-box');

        if (chatInput.value.trim() !== '') {
            let userMessage = chatInput.value.trim();

            // Tambahkan pesan pengguna ke chat box
            let userMessageHtml = '<div class="text-right mb-2"><span class="badge badge-primary">' + userMessage + '</span></div>';
            chatBox.innerHTML += userMessageHtml;

            // Bersihkan input
            chatInput.value = '';

            // Scroll ke bagian bawah
            chatBox.scrollTop = chatBox.scrollHeight;

            // Kirim pesan ke server untuk mendapatkan respons Gemini
            fetch('{{ route('chat.gemini-response') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                if (data.response) {
                    let geminiMessageHtml = '<div class="text-left mb-2"><span class="badge badge-secondary">' + data.response + '</span></div>';
                    chatBox.innerHTML += geminiMessageHtml;

                    // Scroll ke bagian bawah
                    chatBox.scrollTop = chatBox.scrollHeight;
                } else if (data.error) {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});
</script>
@endpush
@push('styles')
<style>
  .card-header {
    font-size: 1.5rem;
  }

  .badge-primary {
    background-color: #007bff;
    color: white;
  }

  .badge-secondary {
    background-color: #6c757d;
    color: white;
  }
</style>
@endpush
@endsection