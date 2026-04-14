<?php
/**
 * MediCare Plus - Chatbot
 * Author: Prakhar Agrawal
 * Description: A help chatbot with smart tab navigation
 */

// Check if user is logged in
$isLoggedIn = isset($_SESSION['username']) && !empty($_SESSION['username']);
?>
<style>
  #chat-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: #1b5e20;
    border-radius: 50%;
    border: none;
    cursor: pointer;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
  }
  #chat-btn .chat-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: red;
    color: white;
    font-size: 10px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #chatbox {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 350px;
    max-height: 520px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    z-index: 9998;
    overflow: hidden;
    font-family: 'IBM Plex Sans', sans-serif;
  }
  #chatbox.open { display: flex; }

  .chat-header {
    background: linear-gradient(to right, #1b5e20, #00897b);
    color: white;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .chat-header .avatar {
    width: 38px;
    height: 38px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }
  .chat-header .info { flex: 1; }
  .chat-header .info h4 { margin: 0; font-size: 14px; font-weight: 600; }
  .chat-header .info span { font-size: 11px; opacity: 0.85; }
  .chat-header .close-btn {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    padding: 0;
    line-height: 1;
  }

  .chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 14px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    background: #f5f7fa;
  }

  .msg {
    max-width: 85%;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    line-height: 1.5;
  }
  .msg.bot {
    background: #fff;
    border: 1px solid #e0e0e0;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
  }
  .msg.user {
    background: #1b5e20;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
  }

  .options-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
    margin-top: 6px;
  }
  .opt-btn {
    background: #fff;
    border: 1.5px solid #1b5e20;
    color: #1b5e20;
    border-radius: 10px;
    padding: 8px 6px;
    font-size: 12px;
    cursor: pointer;
    text-align: center;
    font-weight: 500;
    transition: all 0.2s;
    font-family: 'IBM Plex Sans', sans-serif;
  }
  .opt-btn:hover { background: #1b5e20; color: white; }

  .back-btn {
    background: none;
    border: none;
    color: #1b5e20;
    font-size: 12px;
    cursor: pointer;
    padding: 0;
    margin-top: 6px;
    text-decoration: underline;
    font-family: 'IBM Plex Sans', sans-serif;
  }

  .chat-input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid #eee;
    background: #fff;
    gap: 8px;
  }
  .chat-input-area input {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 8px 14px;
    font-size: 13px;
    outline: none;
    font-family: 'IBM Plex Sans', sans-serif;
  }
  .chat-input-area button {
    background: #1b5e20;
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .typing {
    display: flex;
    gap: 4px;
    padding: 10px 14px;
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    border-bottom-left-radius: 4px;
    align-self: flex-start;
    width: fit-content;
  }
  .typing span {
    width: 7px; height: 7px;
    background: #aaa;
    border-radius: 50%;
    animation: bounce 1.2s infinite;
  }
  .typing span:nth-child(2) { animation-delay: 0.2s; }
  .typing span:nth-child(3) { animation-delay: 0.4s; }
  @keyframes bounce {
    0%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-6px); }
  }

  .login-notice {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 10px;
    padding: 10px 12px;
    font-size: 12px;
    color: #856404;
    margin-top: 6px;
  }
  .login-notice a {
    color: #1b5e20;
    font-weight: 600;
    text-decoration: underline;
  }
</style>

<button id="chat-btn" onclick="toggleChat()" title="Need Help?">
  <svg width="28" height="28" viewBox="0 0 24 24" fill="white">
    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/>
  </svg>
  <div class="chat-badge">1</div>
</button>

<div id="chatbox">
  <div class="chat-header">
    <div class="avatar">+</div>
    <div class="info">
      <h4>MediCare Assistant</h4>
      <span>&#9679; Online • Replies instantly</span>
    </div>
    <button class="close-btn" onclick="toggleChat()">&times;</button>
  </div>
  <div class="chat-messages" id="chat-messages"></div>
  <div class="chat-input-area">
    <input type="text" id="user-input" placeholder="Type your message..." onkeydown="if(event.key==='Enter') sendUserMsg()" />
    <button onclick="sendUserMsg()">&#9658;</button>
  </div>
</div>

<script>
var chatOpen = false;

// PHP passes login status to JavaScript
var isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

function goToTab(tabId) {
  var tabLink = document.querySelector(tabId);
  if (tabLink) { tabLink.click(); }
}

var responses = {
  "Book Appointment": {
    reply: "Taking you to Book Appointment now...",
    action: function() { toggleChat(); goToTab('#list-home-list'); },
    loginReply: "You need to login first to book an appointment.",
    link: "index.php"
  },
  "Find Doctor": {
    reply: "You can find a doctor by specialization on our homepage.",
    loginReply: "You can browse doctors on our homepage without logging in!",
    link: "index.php"
  },
  "Check Appointments": {
    reply: "Opening your Appointment History now...",
    action: function() { toggleChat(); goToTab('#list-pat-list'); },
    loginReply: "You need to login first to view your appointments.",
    link: "index.php"
  },
  "Emergency Help": {
    reply: "For EMERGENCY please:\n\nCall immediately: 112 (National Emergency)\nHospital Helpline: 1800-XXX-XXXX\n\nOr visit the nearest emergency ward. Our staff is available 24/7.",
    link: null
  },
  "Prescription": {
    reply: "Opening your Prescriptions now...",
    action: function() { toggleChat(); goToTab('#list-pres-list'); },
    loginReply: "You need to login first to view your prescriptions.",
    link: "index.php"
  },
  "Contact Hospital": {
    reply: "You can contact us at:\n\nEmail: hospital@medicare.com\nPhone: 1800-XXX-XXXX\nAddress: Hospital Address Here\nTiming: Mon-Sat, 9AM to 6PM",
    link: "contact.html"
  }
};

var mainMenuOptions = ["Book Appointment","Find Doctor","Check Appointments","Emergency Help","Prescription","Contact Hospital"];

function toggleChat() {
  chatOpen = !chatOpen;
  var box = document.getElementById('chatbox');
  if (chatOpen) {
    box.classList.add('open');
    document.querySelector('.chat-badge').style.display = 'none';
    var msgs = document.getElementById('chat-messages');
    if (msgs.children.length === 0) {
      setTimeout(function() { showWelcome(); }, 300);
    }
  } else {
    box.classList.remove('open');
  }
}

function showWelcome() {
  showTyping(function() {
    var greeting = isLoggedIn
      ? "Hello! I'm your MediCare Assistant. How can I help you today?"
      : "Hello! I'm your MediCare Assistant.\n\nNote: You are not logged in. Some features require login.";
    addBotMsg(greeting);
    setTimeout(function() {
      showTyping(function() {
        addBotMsg("Please select your issue:", mainMenuOptions);
      });
    }, 600);
  });
}

function addBotMsg(text, options) {
  var msgs = document.getElementById('chat-messages');
  var div = document.createElement('div');
  div.className = 'msg bot';
  div.style.whiteSpace = 'pre-line';
  div.innerText = text;
  if (options) {
    var grid = document.createElement('div');
    grid.className = 'options-grid';
    options.forEach(function(opt) {
      var btn = document.createElement('button');
      btn.className = 'opt-btn';
      btn.innerText = opt;
      btn.onclick = function() { handleOption(opt); };
      grid.appendChild(btn);
    });
    div.appendChild(grid);
  }
  msgs.appendChild(div);
  msgs.scrollTop = msgs.scrollHeight;
}

function addLoginNotice(linkHref) {
  var msgs = document.getElementById('chat-messages');
  var div = document.createElement('div');
  div.className = 'msg bot';

  var notice = document.createElement('div');
  notice.className = 'login-notice';
  notice.innerHTML = '&#128274; Please <a href="' + (linkHref || 'index.php') + '">Login here</a> to access this feature.';
  div.appendChild(notice);

  var backBtn = document.createElement('button');
  backBtn.className = 'back-btn';
  backBtn.innerText = 'Back to main menu';
  backBtn.onclick = showMainMenu;
  div.appendChild(backBtn);

  msgs.appendChild(div);
  msgs.scrollTop = msgs.scrollHeight;
}

function addUserMsg(text) {
  var msgs = document.getElementById('chat-messages');
  var div = document.createElement('div');
  div.className = 'msg user';
  div.innerText = text;
  msgs.appendChild(div);
  msgs.scrollTop = msgs.scrollHeight;
}

function showTyping(callback) {
  var msgs = document.getElementById('chat-messages');
  var typing = document.createElement('div');
  typing.className = 'typing';
  typing.id = 'typing-indicator';
  typing.innerHTML = '<span></span><span></span><span></span>';
  msgs.appendChild(typing);
  msgs.scrollTop = msgs.scrollHeight;
  setTimeout(function() {
    var t = document.getElementById('typing-indicator');
    if (t) t.remove();
    callback();
  }, 900);
}

function handleOption(option) {
  addUserMsg(option);
  var res = responses[option];
  if (!res) return;

  showTyping(function() {

    // Logged in + has a tab action → go directly to tab
    if (isLoggedIn && res.action) {
      addBotMsg(res.reply);
      setTimeout(res.action, 700);

    // NOT logged in + feature needs login → show login notice
    } else if (!isLoggedIn && res.action) {
      addBotMsg(res.loginReply || "You need to login to access this feature.");
      setTimeout(function() {
        addLoginNotice(res.link || 'index.php');
      }, 400);

    // Has external link (no login required)
    } else if (res.link) {
      addBotMsg(res.reply);
      setTimeout(function() {
        var msgs = document.getElementById('chat-messages');
        var wrapper = document.createElement('div');
        wrapper.className = 'msg bot';

        var a = document.createElement('a');
        a.href = res.link;
        a.style.cssText = 'display:inline-block;background:#1b5e20;color:white;padding:8px 16px;border-radius:8px;font-size:13px;text-decoration:none;margin-top:4px;';
        a.innerText = 'Go to Page';

        var backBtn = document.createElement('button');
        backBtn.className = 'back-btn';
        backBtn.innerText = 'Back to main menu';
        backBtn.onclick = showMainMenu;

        wrapper.appendChild(a);
        wrapper.appendChild(document.createElement('br'));
        wrapper.appendChild(backBtn);
        msgs.appendChild(wrapper);
        msgs.scrollTop = msgs.scrollHeight;
      }, 400);

    // No link, no action (Emergency Help)
    } else {
      addBotMsg(res.reply);
      setTimeout(function() { showMainMenu(); }, 800);
    }
  });
}

function showMainMenu() {
  showTyping(function() {
    addBotMsg("Is there anything else I can help you with?", mainMenuOptions);
  });
}

function sendUserMsg() {
  var input = document.getElementById('user-input');
  var text = input.value.trim();
  if (!text) return;
  addUserMsg(text);
  input.value = '';

  var lower = text.toLowerCase();
  var matched = false;
  mainMenuOptions.forEach(function(opt) {
    if (lower.indexOf(opt.toLowerCase()) !== -1) {
      matched = true;
      handleOption(opt);
    }
  });

  if (!matched) {
    showTyping(function() {
      addBotMsg("I'm not sure about that. Please choose from the options below:", mainMenuOptions);
    });
  }
}
</script>
