import Swal from 'sweetalert2'

// Sentry error handling knows to ignore these type of promise rejections
const userAborted = 'User aborted'

// Show a simple confirm modal asking user to confirm their action
export function confirmModal(title, html, opts = {}) {
  return Swal.fire({
    title,
    html,
    icon: 'warning',
    showCancelButton: true,
    ...opts
  }).then(result => {
    if (!result.isConfirmed) return Promise.reject(userAborted)
    return result
  })
}
