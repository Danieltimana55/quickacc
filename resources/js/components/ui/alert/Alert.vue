<script setup lang="ts">
import { cn } from "@/lib/utils";

interface Props {
  variant?: "default" | "destructive";
}

const props = withDefaults(defineProps<Props>(), {
  variant: "default",
});
</script>

<template>
  <div
    :class="cn(
      'relative w-full rounded-lg border p-4 [&:has(svg)]:pl-11 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground',
      props.variant === 'destructive' && 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
    )"
  >
    <slot />
  </div>
</template> 