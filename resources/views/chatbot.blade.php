<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between  ">
            <div class="flex items-center space-x-4 ">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-gray-900">
                        {{ __('Asistent jurnalmu') }}
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Asisten pribadi untuk jurnal dan catatan Anda</p>
                </div>
            </div>
    </x-slot>

    <div class="px-2">
        <div class="flex justify-center items-center min-h-[calc(100vh-9rem)]">
            <div class="flex flex-col w-full max-w-4xl h-[80vh] overflow-hidden">
                
                <!-- Header -->

                <!-- Chat Area -->
                <div id="chat-box" class="flex-1 overflow-y-auto px-6 py-6 bg-gradient-to-b from-gray-50/50 to-white space-y-4 text-sm">
                    <!-- Welcome message will be added here -->
                </div>

                <!-- Input Area -->
                <div class="bg-white/80 backdrop-blur-sm border-t border-gray-200/50 px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-1 relative">
                            <input type="text" id="message-input" 
                                placeholder="Tanyakan sesuatu tentang jurnal Anda..."
                                class="w-full border-2 border-gray-200 rounded-2xl px-6 py-3 pr-12 focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all duration-200 bg-white/90 backdrop-blur-sm shadow-sm">
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </div>
                        </div>
                        <button id="send-btn"
                            class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-indigo-700 hover:to-indigo-700 text-white px-8 py-3 rounded-2xl font-medium transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 flex items-center gap-2">
                            <span>Kirim</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="flex gap-2 mt-3 flex-wrap">
                        <button class="quick-action-btn bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-4 py-2 rounded-full text-xs font-medium transition-colors duration-200" data-message="Bantu saya membuat jurnal akademik">
                            📝 Buat Jurnal
                        </button>
                        <button class="quick-action-btn bg-indigo-100 hover:bg-indigo-200 text-indigo-700 px-4 py-2 rounded-full text-xs font-medium transition-colors duration-200" data-message="Bagaimana cara menulis jurnal terindeks sinta yang baik?">
                            💡 Tips Menulis
                        </button>
                        <button class="quick-action-btn bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded-full text-xs font-medium transition-colors duration-200" data-message="Analisis tren atau permasalahan yang relavan saat ini">
                            📊 Analisis Permasalah terbaru 
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        const chatBox = document.getElementById("chat-box");
        const messageInput = document.getElementById("message-input");
        const sendButton = document.getElementById("send-btn");
        const quickActionBtns = document.querySelectorAll('.quick-action-btn');

        // Welcome message
        function showWelcomeMessage() {
            const welcomeMessage = `Halo! 👋 Selamat datang di JournalBot Assistant!

Saya adalah asisten virtual yang siap membantu Anda dalam:

1. Membuat dan mengorganisir jurnal harian
2. Memberikan inspirasi untuk menulis
3. Menganalisis pola mood dan emosi
4. Memberikan tips dan saran penulisan
5. Membantu refleksi diri yang lebih baik

Silakan mulai dengan mengetik pertanyaan atau pilih salah satu tombol bantuan cepat di bawah. Saya siap membantu Anda kapan saja! 😊`;

            addMessage(welcomeMessage, "ai");
        }

        function addMessage(content, sender) {
            const messageElement = document.createElement("div");
            messageElement.classList.add("flex", "gap-3", "max-w-full");

            const avatarElement = document.createElement("div");
            avatarElement.classList.add("w-8", "h-8", "rounded-full", "flex-shrink-0", "flex", "items-center", "justify-center", "text-sm", "font-medium");

            const messageContent = document.createElement("div");
            messageContent.classList.add("flex-1", "max-w-[calc(100%-3rem)]");

            const messageBubble = document.createElement("div");
            messageBubble.classList.add("rounded-2xl", "px-4", "py-3", "break-words", "whitespace-pre-wrap", "shadow-sm");

            if (sender === "user") {
                messageElement.classList.add("justify-end");
                avatarElement.classList.add("bg-blue-500", "text-white", "order-2");
                avatarElement.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>';
                messageBubble.classList.add("bg-gradient-to-r", "from-blue-500", "to-indigo-600", "text-white", "ml-11");
                messageContent.classList.add("order-1");
            } else {
                messageElement.classList.add("justify-start");
                avatarElement.classList.add("bg-gradient-to-r", "from-green-400", "to-blue-500", "text-white");
                avatarElement.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>';
                messageBubble.classList.add("bg-white", "text-gray-800", "border", "border-gray-200", "mr-auto");
            }

            // messageBubble.textContent = content;
            messageBubble.innerHTML = marked.parse(content);
            messageContent.appendChild(messageBubble);
            messageElement.appendChild(avatarElement);
            messageElement.appendChild(messageContent);
            
            chatBox.appendChild(messageElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function addTypingIndicator() {
            const typingElement = document.createElement("div");
            typingElement.classList.add("flex", "gap-3", "max-w-full", "justify-start");
            typingElement.id = "typing-indicator";

            const avatarElement = document.createElement("div");
            avatarElement.classList.add("w-8", "h-8", "rounded-full", "flex-shrink-0", "flex", "items-center", "justify-center", "text-sm", "font-medium", "bg-gradient-to-r", "from-green-400", "to-blue-500", "text-white");
            avatarElement.innerHTML = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>';

            const messageContent = document.createElement("div");
            messageContent.classList.add("flex-1", "max-w-[calc(100%-3rem)]");

            const messageBubble = document.createElement("div");
            messageBubble.classList.add("rounded-2xl", "px-4", "py-3", "bg-white", "border", "border-gray-200", "mr-auto", "shadow-sm");
            messageBubble.innerHTML = '<div class="flex gap-1"><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div></div>';

            messageContent.appendChild(messageBubble);
            typingElement.appendChild(avatarElement);
            typingElement.appendChild(messageContent);
            
            chatBox.appendChild(typingElement);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function removeTypingIndicator() {
            const typingIndicator = document.getElementById("typing-indicator");
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }

        async function sendMessage(message = null) {
            const userMessage = message || messageInput.value.trim();
            if (!userMessage) return;

            addMessage(userMessage, "user");
            if (!message) messageInput.value = "";
            
            addTypingIndicator();

            try {
                const response = await axios.post(
                    "https://api.deepenglish.com/api/gpt_open_ai/chatnew",
                    {
                        messages: [
                            { 
                                role: "system", 
                                content: "Kamu adalah JournalBot Assistant untuk jurnal akademik, asisten virtual yang membantu pengguna dalam membuat jurnal akademik yang trindeks, mengorganisir jurnal di scopus dan sinta, memberikan inspirasi menulis, menganalisis mood, dan memberikan saran terkait penulisan jurnal. Gunakan bahasa Indonesia yang ramah, hangat, dan supportif. Berikan respon yang thoughtful dan helpful untuk membantu pengguna dalam journaling akademik mereka."
                            },
                            { role: "user", content: userMessage }
                        ],
                        temperature: 0.8,
                        projectName: "wordpress",
                    },
                    {
                        headers: {
                            Authorization: "Bearer UFkOfJaclj61OxoD7MnQknU1S2XwNdXMuSZA+EZGLkc=",
                        },
                    }
                );

                removeTypingIndicator();
                const aiMessage = response.data.message || "Maaf, saya tidak dapat merespons saat ini.";
                addMessage(aiMessage, "ai");
            } catch (error) {
                console.error("Error:", error);
                removeTypingIndicator();
                addMessage("Maaf, terjadi kesalahan saat menghubungi asisten. Silakan coba lagi.", "ai");
            }
        }

        // Event listeners
        sendButton.addEventListener("click", () => sendMessage());
        messageInput.addEventListener("keydown", (e) => {
            if (e.key === "Enter" && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Quick action buttons
        quickActionBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const message = btn.getAttribute('data-message');
                sendMessage(message);
            });
        });

        // Show welcome message on page load
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                showWelcomeMessage();
            }, 500);
        });
    </script>
    @endpush
</x-app-layout>