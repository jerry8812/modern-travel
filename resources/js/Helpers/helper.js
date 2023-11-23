export function formatNZCurrency(amount) {
  const number = isNaN(amount) ? 0 : amount
  return Number(number).toLocaleString('en-NZ', { style: 'currency', currency: 'NZD' })
}
