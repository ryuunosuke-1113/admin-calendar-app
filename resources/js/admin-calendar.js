import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

// CSRFトークン取得
const csrfToken = () =>
  document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? ''

document.addEventListener('DOMContentLoaded', () => {
  const calendarEl = document.getElementById('calendar')
  if (!calendarEl) return

  // ===== モーダル要素 =====
  const overlay = document.getElementById('eventModalOverlay')
  const closeBtn = document.getElementById('eventModalCloseBtn')

  const titleInput = document.getElementById('modalTitle')
  const notesInput = document.getElementById('modalNotes')
  const startEl = document.getElementById('modalStart')
  const endEl = document.getElementById('modalEnd')
  const allDayEl = document.getElementById('modalAllDay')

  const editBtn = document.getElementById('editBtn')
  const saveBtn = document.getElementById('saveBtn')
  const cancelEditBtn = document.getElementById('cancelEditBtn')
  const deleteBtn = document.getElementById('deleteBtn')

  // クリックしたイベントを保持
  let currentEvent = null
  let originalTitle = ''
  let originalNotes = ''

  const openModal = () => { overlay.style.display = 'block' }
  const closeModal = () => {
    overlay.style.display = 'none'
    setViewMode()
    currentEvent = null
  }

  const setViewMode = () => {
    titleInput.disabled = true
    notesInput.disabled = true

    editBtn.style.display = 'inline-block'
    deleteBtn.style.display = 'inline-block'
    saveBtn.style.display = 'none'
    cancelEditBtn.style.display = 'none'
  }

  const setEditMode = () => {
    titleInput.disabled = false
    notesInput.disabled = false

    editBtn.style.display = 'none'
    deleteBtn.style.display = 'none'
    saveBtn.style.display = 'inline-block'
    cancelEditBtn.style.display = 'inline-block'
  }

  // オーバーレイクリックで閉じる（カード内クリックは閉じない）
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) closeModal()
  })
  closeBtn.addEventListener('click', closeModal)

  cancelEditBtn.addEventListener('click', () => {
    // 入力を元に戻して閲覧モードへ
    titleInput.value = originalTitle
    notesInput.value = originalNotes
    setViewMode()
  })

  editBtn.addEventListener('click', () => {
    setEditMode()
  })

  saveBtn.addEventListener('click', async () => {
    if (!currentEvent) return

    const newTitle = titleInput.value.trim()
    const newNotes = notesInput.value

    if (!newTitle) {
      alert('タイトルは必須です')
      return
    }

    const res = await fetch(`/admin/events/${currentEvent.id}`, {
      method: 'PATCH',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken(),
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        title: newTitle,
        notes: newNotes,
      }),
    })

    if (!res.ok) {
      const text = await res.text()
      console.error('PATCH failed', res.status, text)
      alert(`更新に失敗しました（${res.status}）`)
      return
    }

    // 画面反映
    currentEvent.setProp('title', newTitle)
    currentEvent.setExtendedProp('notes', newNotes)

    // 元データ更新して閲覧モードへ
    originalTitle = newTitle
    originalNotes = newNotes
    setViewMode()
  })

  deleteBtn.addEventListener('click', async () => {
    if (!currentEvent) return

    const ok = confirm(`「${currentEvent.title}」を削除しますか？`)
    if (!ok) return

    const res = await fetch(`/admin/events/${currentEvent.id}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken(),
        'Accept': 'application/json',
      },
    })

    if (!res.ok) {
      const text = await res.text()
      console.error('DELETE failed', res.status, text)
      alert(`削除に失敗しました（${res.status}）`)
      return
    }

    currentEvent.remove()
    closeModal()
  })

  // ===== FullCalendar =====
  const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    events: '/admin/events',

    // 追加はとりあえず prompt のまま（後でモーダル化可能）
    dateClick: async (info) => {
      const title = prompt('予定タイトルを入力してください')
      if (!title) return

      const payload = {
        title,
        start_at: info.dateStr,
        end_at: info.dateStr,
        all_day: true,
        notes: '',
      }

      const res = await fetch('/admin/events', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken(),
          'Accept': 'application/json',
        },
        body: JSON.stringify(payload),
      })

      if (!res.ok) {
        const text = await res.text()
        console.error('POST failed', res.status, text)
        alert(`追加に失敗しました（${res.status}）`)
        return
      }

      calendar.refetchEvents()
    },

    // 予定クリック → モーダル表示
    eventClick: (info) => {
      currentEvent = info.event

      const notes = currentEvent.extendedProps?.notes ?? ''
      const start = currentEvent.start ? currentEvent.start.toLocaleString() : '未設定'
      const end = currentEvent.end ? currentEvent.end.toLocaleString() : '未設定'
      const allDay = currentEvent.allDay ? 'はい' : 'いいえ'

      titleInput.value = currentEvent.title
      notesInput.value = notes
      startEl.textContent = start
      endEl.textContent = end
      allDayEl.textContent = allDay

      originalTitle = currentEvent.title
      originalNotes = notes

      setViewMode()
      openModal()
    },
  })

  calendar.render()
})
