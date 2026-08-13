<?php
function rich_editor(string $name, string $value='', string $id='richContent'): void { ?>
<div class="rich-editor" data-editor-wrap="<?=e($id)?>" style="--editor-accent:#2563eb">
  <div class="flex flex-wrap gap-1 border border-slate-200 border-b-0 rounded-t-2xl bg-slate-50 p-2">
    <?php foreach([
      ['bold','Bold','solar:text-bold-linear'],['italic','Italic','solar:text-italic-linear'],['underline','Underline','solar:text-underline-linear'],
      ['insertUnorderedList','Bullets','solar:list-linear'],['insertOrderedList','Numbered','solar:list-check-linear'],
      ['formatBlock|H2','Heading','solar:text-field-linear'],['formatBlock|H3','Subheading','solar:text-field-focus-linear'],
      ['justifyLeft','Left','solar:text-align-left-linear'],['justifyCenter','Center','solar:text-align-center-linear'],['justifyRight','Right','solar:text-align-right-linear'],
      ['createLink','Link','solar:link-linear'],['removeFormat','Clear','solar:eraser-linear'],['undo','Undo','solar:undo-left-round-linear'],['redo','Redo','solar:undo-right-round-linear']
    ] as $b): [$cmd,$label,$icon]=array_pad(explode('|',$b[0]),2,null); ?>
      <button type="button" class="editor-btn" data-cmd="<?=e($cmd)?>" data-value="<?=e($b[0])?>" title="<?=e($label)?>"><span class="iconify" data-icon="<?=e($icon)?>"></span></button>
    <?php endforeach; ?>
    <button type="button" class="editor-btn" data-source-toggle title="HTML Source"><span class="iconify" data-icon="solar:code-linear"></span></button>
  </div>
  <div class="editor-main border border-slate-200 rounded-b-2xl overflow-hidden bg-white">
    <div class="editor-visual prose max-w-none min-h-72 p-5 sm:p-6 outline-none rounded-b-2xl" contenteditable="true" spellcheck="true"><?=($value)?></div>
    <textarea class="editor-source hidden w-full min-h-72 p-5 sm:p-6 font-mono text-sm outline-none rounded-b-2xl" spellcheck="false"><?=e($value)?></textarea>
  </div>
  <textarea name="<?=e($name)?>" class="editor-hidden" hidden></textarea>
  <div class="flex items-center justify-between gap-2 text-xs text-slate-400 mt-2"><span>Rich text + HTML source · paste images or use browser upload.</span><span class="editor-count">0 words</span></div>
</div>
<script>
(()=>{const wrap=document.querySelector('[data-editor-wrap="<?=e($id)?>"]'); if(!wrap)return; const visual=wrap.querySelector('.editor-visual'),source=wrap.querySelector('.editor-source'),hidden=wrap.querySelector('.editor-hidden'),count=wrap.querySelector('.editor-count');
const sync=()=>{hidden.value=visual.classList.contains('hidden')?source.value:visual.innerHTML; count.textContent=((visual.innerText||'').trim().match(/\S+/g)||[]).length+' words';};
visual.addEventListener('input',sync); source.addEventListener('input',sync);
wrap.querySelectorAll('.editor-btn').forEach(btn=>btn.addEventListener('click',()=>{const cmd=btn.dataset.cmd;if(btn.hasAttribute('data-source-toggle')){source.classList.toggle('hidden');visual.classList.toggle('hidden');sync();return;} let val=null;if(cmd==='formatBlock'){const v=btn.dataset.value.split('|')[1];val='<'+v+'>';} if(cmd==='createLink'){val=prompt('Enter URL');if(!val)return;} document.execCommand(cmd,false,val);visual.focus();sync();}));
visual.addEventListener('paste',()=>setTimeout(sync,0)); sync();
})();
</script>
<style>.rich-editor .editor-btn{width:36px;height:36px;border-radius:10px;display:grid;place-items:center;color:#475569;border:1px solid #e2e8f0;background:#fff}.rich-editor .editor-btn:hover{background:#f1f5f9;color:#0f172a}.rich-editor .editor-main{min-height:290px;background:var(--admin-surface,#fff)!important}.rich-editor .editor-visual,.rich-editor .editor-source{color:var(--admin-text,#0f172a);background:var(--admin-surface,#fff)!important}html[data-theme="dark"] .rich-editor .editor-btn{background:#101817;border-color:rgba(255,255,255,.10);color:#e5e7eb}</style>
<?php }
?>
