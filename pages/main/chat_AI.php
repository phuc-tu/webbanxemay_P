<!-- CHAT BOT AI GIẢ LẬP, chỉ cần nhúng file này thôi! -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<style>
#fakeChatBtn {
  position: fixed; bottom: 35px; right: 35px; z-index: 9999;
  background: #0084FF; width:58px; height:58px; border-radius:50%;
  display: flex; justify-content: center; align-items: center;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
  cursor: pointer; transition: box-shadow .2s;
}
#fakeChatBtn i { color:#fff; font-size:30px; }
#fakeChatBox {
  display: none; position:fixed; bottom:108px; right:35px; z-index:10000;
  width:340px; max-width:96vw; border-radius:13px; overflow:hidden;
  background: #fff; box-shadow: 0 8px 32px rgba(44,62,80,0.16);
  animation:fadeInUp .3s;
}
@keyframes fadeInUp{from{transform:translateY(25px); opacity:0;}to{transform:translateY(0); opacity:1;}}
#fakeChatHeader {
  background: #0084FF; color:#fff; font-weight:bold; padding:12px 15px;
  display:flex; justify-content:space-between; align-items:center;
}
#fakeChatMessages { padding:14px; height:220px; overflow-y:auto; background:#fafbfc;}
.fakeai-msg { background:#0084FF; color:#fff; border-radius:13px 13px 4px 13px; padding:8px 11px; margin:6px 0; max-width:80%; }
.fakeai-user { background:#ececec; color:#333; border-radius:13px 13px 13px 4px; padding:8px 11px; margin:6px 0 6px auto; max-width:80%; text-align:right;}
#fakeChatFooter { border-top:1px solid #eee; padding:9px 10px; background:#fff;}
#fakeChatFooter input { width:74%; border-radius:5px; border:1px solid #ccc; padding:7px 8px;}
#fakeChatFooter button { background:#0084FF;color:#fff; border:none; border-radius:5px; padding:7px 14px; margin-left:5px;}
#fakeChatClose { font-size:24px; cursor:pointer; margin-left:7px;}
#fakeChatBtn:hover { box-shadow:0 5px 24px rgba(0,0,0,0.18);}
</style>
<!-- Icon Chat AI nổi -->
<div id="fakeChatBtn"><i class="fa fa-facebook-messenger"></i></div>
<!-- Khung chatbox ẩn ban đầu -->
<div id="fakeChatBox">
  <div id="fakeChatHeader">
    <span>AI hỗ trợ</span>
    <span id="fakeChatClose">&times;</span>
  </div>
  <div id="fakeChatMessages"></div>
  <div id="fakeChatFooter">
    <input type="text" id="fakeChatInput" placeholder="Nhập câu hỏi...">
    <button id="fakeChatSend">Gửi</button>
  </div>
</div>
<script>
// Mẫu trả lời "AI" ngẫu nhiên
const fakeAI = [
  "Xin chào! Tôi là trợ lý AI của shop, bạn hỏi gì cũng được nha.",
  "Cảm ơn bạn đã quan tâm sản phẩm. Bạn muốn tư vấn gì nào?",
  "Hiện sản phẩm còn hàng. Giao trong 2-3 ngày nhé!",
  "Mọi thắc mắc về đơn hàng bạn gửi tại đây, shop sẽ hỗ trợ.",
  "Bạn hãy để lại số điện thoại để được tư vấn kỹ hơn.",
  "AI shop luôn sẵn sàng hỗ trợ bạn bất kể ngày đêm ^^"
];

document.getElementById('fakeChatBtn').onclick = function() {
  document.getElementById('fakeChatBox').style.display = 'block';
  setTimeout(()=>document.getElementById('fakeChatInput').focus(), 180);
};
document.getElementById('fakeChatClose').onclick = function() {
  document.getElementById('fakeChatBox').style.display = 'none';
};
function sendFakeChat() {
  let value = document.getElementById('fakeChatInput').value.trim();
  if (value) {
    let messages = document.getElementById('fakeChatMessages');
    messages.innerHTML += `<div class="fakeai-user">${value}</div>`;
    document.getElementById('fakeChatInput').value = "";
    messages.scrollTop = messages.scrollHeight;
    setTimeout(()=>{
      let aiReply = fakeAI[Math.floor(Math.random()*fakeAI.length)];
      messages.innerHTML += `<div class="fakeai-msg">${aiReply}</div>`;
      messages.scrollTop = messages.scrollHeight;
    }, 480);
  }
}
document.getElementById('fakeChatSend').onclick = sendFakeChat;
document.getElementById('fakeChatInput').addEventListener('keydown', function(e) {
  if(e.key==="Enter") {e.preventDefault();sendFakeChat();}
});
</script>