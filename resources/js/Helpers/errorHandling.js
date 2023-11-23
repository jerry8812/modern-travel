/**
 * Global error handler interceptor for all axios responses
 */

import Swal from 'sweetalert2'
import { flatMap, uniq } from 'lodash'

const defaultErrorHeading = 'Whoops!'
const defaultErrorMessage = 'Something went wrong on our end.<br>Please try again shortly.'

function showError(message, heading) {
  Swal.fire({
    title: heading || defaultErrorHeading,
    html: message || defaultErrorMessage,
    icon: 'error',
    keydownListenerCapture: true
  })
}

// Attempts to handle common errors such as laravel validation and backend responses.
//
export default function axiosErrorInterceptor(httpStatus, responseData) {
  let message
  switch (httpStatus) {
    case 0:
      return // Do nothing on XHR aborts
    case 403:
      return showError('You are not allowed to perform that action.', 'Permission Denied')
    case 404:
      return showError('A page or resource you requested could not be found.<br>Go back and try again.', 'Its Gone!')
    case 419:
      return showError('A security token expired. The page needs to be reloaded')
    case 422:
      // Also handles laravel validation messages
      message = uniq(flatMap(responseData.errors, messages => messages)).join('<br>')
      return showError(message || responseData.message || 'Please double check the data you have submitted and try again')
    case 500:
    // No specific response returned / internal server error? Just show general error message.
    // On non-dev environment we get a generic "Server Error" message which is a bit unfriendly.
      return showError(responseData.message != 'Server Error' ? responseData.message : defaultErrorMessage, 'It Broke!')
    case 502:
    case 503:
    case 504:
      return showError(responseData.message != 'Server Error' ? responseData.message : defaultErrorMessage, 'Service Unavailable')
  }

  return showError()
}

