{{-- resources/views/landing/chatbot.blade.php --}}
<div class="chatbot-widget">
    <button class="chatbot-trigger" id="chatbotTrigger">
        <i class="fas fa-comments" id="chatbotIcon"></i>
    </button>

    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header">
            <div class="chatbot-avatar">
                <i class="fas fa-robot"></i>
            </div>
            <div class="chatbot-info">
                <h3>Asisten PPDB</h3>
                <p>SMP Harapan Bangsa</p>
            </div>
        </div>

        <div class="chatbot-messages" id="chatbotMessages">
            <div class="message bot">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    Halo! Saya asisten virtual untuk PPDB SMP Harapan Bangsa. Ada yang bisa saya bantu mengenai
                    pendaftaran?

                    <div class="quick-questions">
                        <button class="quick-question" onclick="sendQuickQuestion('Kapan jadwal pendaftaran?')">
                            📅 Kapan jadwal pendaftaran?
                        </button>
                        <button class="quick-question" onclick="sendQuickQuestion('Berapa biaya pendaftaran?')">
                            💰 Berapa biaya pendaftaran?
                        </button>
                        <button class="quick-question" onclick="sendQuickQuestion('Apa saja jalur pendaftaran?')">
                            🛣️ Apa saja jalur pendaftaran?
                        </button>
                        <button class="quick-question" onclick="sendQuickQuestion('Berkas apa saja yang diperlukan?')">
                            📄 Berkas apa saja yang diperlukan?
                        </button>
                    </div>
                </div>
            </div>

            <div class="message bot" style="display: none;">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="typing-indicator" id="typingIndicator">
                    <div class="typing-dots">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="chatbot-input">
            <div class="input-group">
                <textarea class="input-field" id="messageInput" placeholder="Ketik pertanyaan Anda..." rows="1"></textarea>
                <button class="send-button" id="sendButton">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        class ChatbotWidget {
            constructor() {
                this.isOpen = false;
                this.isLoading = false;
                this.initializeElements();
                this.bindEvents();
            }

            initializeElements() {
                this.trigger = document.getElementById('chatbotTrigger');
                this.container = document.getElementById('chatbotContainer');
                this.messages = document.getElementById('chatbotMessages');
                this.input = document.getElementById('messageInput');
                this.sendButton = document.getElementById('sendButton');
                this.typingIndicator = document.getElementById('typingIndicator');
                this.chatbotIcon = document.getElementById('chatbotIcon');
            }

            bindEvents() {
                this.trigger.addEventListener('click', () => this.toggleChatbot());
                this.sendButton.addEventListener('click', () => this.sendMessage());
                this.input.addEventListener('keypress', (e) => {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        this.sendMessage();
                    }
                });

                // Auto-resize textarea
                this.input.addEventListener('input', () => {
                    this.input.style.height = 'auto';
                    this.input.style.height = Math.min(this.input.scrollHeight, 80) + 'px';
                });
            }

            toggleChatbot() {
                this.isOpen = !this.isOpen;

                if (this.isOpen) {
                    this.container.classList.add('active');
                    this.trigger.classList.add('active');
                    this.chatbotIcon.className = 'fas fa-times';
                    this.input.focus();
                } else {
                    this.container.classList.remove('active');
                    this.trigger.classList.remove('active');
                    this.chatbotIcon.className = 'fas fa-comments';
                }
            }

            async sendMessage(message = null) {
                const text = message || this.input.value.trim();
                if (!text || this.isLoading) return;

                this.addMessage(text, 'user');
                if (!message) {
                    this.input.value = '';
                    this.input.style.height = 'auto';
                }

                this.showTyping();
                this.setLoading(true);

                try {
                    const response = await fetch('/chatbot', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || ''
                        },
                        body: JSON.stringify({
                            message: text
                        })
                    });

                    const data = await response.json();
                    console.log(data);

                    setTimeout(() => {
                        this.hideTyping();

                        if (data.success) {
                            this.addMessage(data.message, 'bot');
                        } else {
                            this.addMessage('Maaf, terjadi kesalahan. Silakan coba lagi nanti.', 'bot');
                        }

                        this.setLoading(false);
                    }, 1000);

                } catch (error) {
                    console.error('Error:', error);
                    this.hideTyping();
                    this.addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi nanti.', 'bot');
                    this.setLoading(false);
                }
            }

            addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}`;

                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.innerHTML = sender === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';

                const content = document.createElement('div');
                content.className = 'message-content';
                content.textContent = text;

                messageDiv.appendChild(avatar);
                messageDiv.appendChild(content);

                // Insert before typing indicator
                const typingMessage = this.typingIndicator.closest('.message');
                this.messages.insertBefore(messageDiv, typingMessage);

                this.scrollToBottom();
            }

            showTyping() {
                this.typingIndicator.style.display = 'block';
                this.typingIndicator.closest('.message').style.display = 'flex';
                this.scrollToBottom();
            }

            hideTyping() {
                this.typingIndicator.style.display = 'none';
                this.typingIndicator.closest('.message').style.display = 'none';
            }

            setLoading(loading) {
                this.isLoading = loading;
                this.sendButton.disabled = loading;
                this.input.disabled = loading;

                if (loading) {
                    this.sendButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                } else {
                    this.sendButton.innerHTML = '<i class="fas fa-paper-plane"></i>';
                }
            }

            scrollToBottom() {
                setTimeout(() => {
                    this.messages.scrollTop = this.messages.scrollHeight;
                }, 100);
            }
        }

        // Global function for quick questions
        function sendQuickQuestion(question) {
            if (window.chatbot) {
                window.chatbot.sendMessage(question);
            }
        }

        // Initialize chatbot when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            window.chatbot = new ChatbotWidget();
        });
    </script>
@endpush
