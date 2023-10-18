export const getStatus = (statusName) => {
  const colors = {
    danger: {
      bgColor: '#f7edb5',
      textColor: '#ba8802'
    },
    info: {
      bgColor: '#a0c7da',
      textColor: '#209ad6'
    },
    success: {
      bgColor: '#9cfece',
      textColor: '#2bb973'
    },
  }

  const status = {
    'HOLDING': {
      name: 'Holding',
      bgColor: colors.danger.bgColor,
      textColor: colors.danger.textColor,
      tailwindClass: `bg-[${colors.danger.bgColor}] text-[${colors.danger.textColor}]`
    },
    'IN PROGRESS': {
      name: 'In Progress',
      bgColor: colors.info.bgColor,
      textColor: colors.info.textColor,
      tailwindClass: `bg-[${colors.info.bgColor}] text-[${colors.info.textColor}]`
    },
    'FINISHED': {
      name: 'Finished',
      bgColor: colors.success.bgColor,
      textColor: colors.success.textColor,
      tailwindClass: `bg-[${colors.success.bgColor}] text-[${colors.success.textColor}]`
    },
  };

  return status ? status[statusName] : status;
}